
<?php 
    require_once '../../models/empresa.php';

    $empresa = new Empresa();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //Iniciamos la sesion para poder acceder al id del usuario
        session_start();
        echo $_SESSION['id_usuario'];
        $user_id  = $_SESSION['id_usuario'];
        $empresa_creada = $empresa->crearEmpresa($user_id,$_POST);

        if($empresa_creada){
            // Redirigir a la página de inicio o dashboard de la empresa
            header("Location: ./dashboard.php");
            echo "Empresa CREADA.";

        } else {
            // Manejar el error de creación de empresa
            echo "Error al crear la empresa. Por favor, inténtelo de nuevo.";
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro de Empresa</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #e8f0fe;
    }
    .form-container {
      max-width: 600px;
      margin: 60px auto;
      background: #fff;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>

<div class="form-container">
  <h2 class="mb-4 text-center text-primary">Registro de Empresa 🏢</h2>

  <form action="#" method="POST">
    <div class="mb-3">
      <label for="nombre_empresa" class="form-label">Nombre de la Empresa</label>
      <input type="text" class="form-control" id="nombre_empresa" name="nombre_empresa" required>
    </div>

    <div class="mb-3">
      <label for="direccion" class="form-label">Dirección</label>
      <input type="text" class="form-control" id="direccion" name="direccion" required>
    </div>

    <div class="mb-3">
      <label for="contacto" class="form-label">Teléfono o contacto</label>
      <input type="text" class="form-control" id="contacto" name="contacto" required>
    </div>

    <div class="d-grid">
      <button type="submit" class="btn btn-primary">Registrar Empresa</button>
    </div>
  </form>
</div>

</body>
</html>
