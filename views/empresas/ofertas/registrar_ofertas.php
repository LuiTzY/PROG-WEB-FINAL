<?php 
    require_once '../../../models/empresa.php';

  session_start();
  $empresa = new Empresa();

  $data = $empresa->obtenerEmpresa($_SESSION['id_usuario']);
    if ($data) {
        // Aquí puedes cargar la información de la empresa en variables para mostrarla en el dashboard
        $id_empresa = $data['id'];
        $nombre_empresa = $data['nombre_empresa'];
        $direccion = $data['direccion'];
        $contacto = $data['contacto'];
    }


    if($_POST){
        // Guardar la oferta en la base de datos
        $oferta = $empresa->crearOferta($id_empresa, $_POST);
    
        if($oferta){
            // Si la oferta se guardó correctamente, redirigir a la página de ofertas
            header("Location: ../dashboard.php?message=Oferta publicada con éxito");
            exit();
        } else {
            // Si hubo un error al guardar la oferta, mostrar un mensaje de error
            $error = "Error al publicar la oferta. Por favor, intenta nuevamente.";
        }
    }   

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Publicar Nueva Oferta</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6f8;
    }
    .form-container {
      max-width: 800px;
      margin: 60px auto;
      background: #ffffff;
      padding: 2.5rem;
      border-radius: 12px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
    }
  </style>
</head>
<body>

<div class="form-container">
  <h2 class="mb-4 text-center text-primary">📢 Publicar Nueva Oferta para tu Empresa <?= $nombre_empresa ?></h2>

  <form action="registrar_ofertas.php" method="POST">
    <!-- Título del Puesto -->
    <div class="mb-3">
      <label for="titulo" class="form-label">Título del Puesto</label>
      <input type="text" class="form-control" id="titulo" name="titulo" required placeholder="Ej. Desarrollador Web Jr.">
    </div>

    <!-- Descripción -->
    <div class="mb-3">
      <label for="descripcion" class="form-label">Descripción del Puesto</label>
      <textarea class="form-control" id="descripcion" name="descripcion" rows="5" required placeholder="Describe las funciones, entorno de trabajo, beneficios que ofreces etc."></textarea>
    </div>

    <!-- Requisitos -->
    <div class="mb-3">
      <label for="requisitos" class="form-label">Requisitos</label>
      <textarea class="form-control" id="requisitos" name="requisitos" rows="4" required placeholder="Conocimientos, habilidades, experiencia..."></textarea>
    </div>

    <!-- Ubicación -->
    <div class="mb-3">
      <label for="ubicacion" class="form-label">Ubicación</label>
      <input type="text" class="form-control" id="ubicacion" name="ubicacion" required placeholder="Ej. Santo Domingo o Remoto">
    </div>

    <!-- Tipo de Contrato -->
    <div class="mb-3">
      <label for="tipo_contrato" class="form-label">Tipo de Contrato</label>
      <select class="form-select" id="tipo_contrato" name="tipo_contrato" required>
        <option selected disabled>Selecciona una opción</option>
        <option>Tiempo completo</option>
        <option>Medio tiempo</option>
        <option>Freelance</option>
        <option>Pasantía</option>
      </select>
    </div>

    <!-- Botón -->
    <div class="d-grid mt-4">
      <button type="submit" class="btn btn-primary">✅ Publicar Oferta</button>
    </div>
  </form>

  <div class="text-center mt-4">
    <a href="../dashboard.php" class="btn btn-outline-secondary">⬅️ Volver al Panel</a>
  </div>
</div>

</body>
</html>
