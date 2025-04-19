<?php
    session_start();
    require_once '../../../models/Empresa.php';

    $id_oferta = $_GET['id'] ?? null;
    
    $empresaModel = new Empresa();
    
    if (!$id_oferta) {
        echo "ID de oferta no válido.";
        header(header: "Location: ../dashboard.php?message=ID de oferta no válido.");
        exit();
    }
    
    //Luego de validar que si tenemos el id de la oferta, obtenemos la oferta
    $oferta = $empresaModel->obtenerOferta($id_oferta);

     if (!$oferta) {
        header(header: "Location: ../dashboard.php?error=No se encontro la oferta.");
        exit();
    }

    if($_POST){
        $id_oferta = $oferta['id'];

        //Si se actualiza la oferta, redireccionamos al dashboard
        if ($empresaModel->actualizarOferta($id_oferta, $_POST)) {
            header(header: "Location: ../dashboard.php?message=Oferta actualizada correctamente.");
            exit();
        } 
        
        //redireccionamos en el caso de que no se haya podido actualizar la oferta
        header(header: "Location: ../dashboard.php?error=Error al actualizar la oferta.");
        exit();
    
    }

   
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Oferta</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6f8;
    }
    .form-container {
      max-width: 800px;
      margin: 60px auto;
      background: #ffffff;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
    }
  </style>
</head>
<body>

<div class="form-container">
  <h2 class="mb-4 text-center text-warning">✏️ Editar Oferta: <?= htmlspecialchars($oferta['titulo']) ?></h2>

  <form action="editar_oferta.php?id=<?= $oferta['id'] ?>" method="POST">
    <input type="hidden" name="id" value="<?= $oferta['id'] ?>">

    <div class="mb-3">
      <label for="titulo" class="form-label">Título del Puesto</label>
      <input type="text" class="form-control" id="titulo" name="titulo" value="<?= htmlspecialchars($oferta['titulo']) ?>" required>
    </div>

    <div class="mb-3">
      <label for="descripcion" class="form-label">Descripción del Puesto</label>
      <textarea class="form-control" id="descripcion" name="descripcion" rows="5" required><?= htmlspecialchars($oferta['descripcion']) ?></textarea>
    </div>

    <div class="mb-3">
      <label for="requisitos" class="form-label">Requisitos</label>
      <textarea class="form-control" id="requisitos" name="requisitos" rows="4" required><?= htmlspecialchars($oferta['requisitos']) ?></textarea>
    </div>

    <div class="d-grid mt-4">
      <button type="submit" class="btn btn-warning">Guardar Cambios</button>
    </div>
  </form>

  <div class="text-center mt-4">
    <a href="listar_ofertas.php" class="btn btn-outline-secondary">⬅️ Volver al listado</a>
  </div>
</div>

</body>
</html>
