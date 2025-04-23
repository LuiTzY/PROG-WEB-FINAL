
<?php 
    require_once __DIR__ . '/../../controllers/authController.php';
    if($_POST){
        // Si se envía el formulario, llamar a la función de login
        login();
        echo $_POST['correo'];
        echo $_POST['passwd'];
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>WEB JOBS Iniciar Sesión</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6f8;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .login-card {
      background: #ffffff;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 400px;
    }
    .login-card h2 {
      margin-bottom: 1.5rem;
    }
  </style>
</head>
<body>

  <div class="login-card">
    <h2 class="text-center">Iniciar Sesión</h2>
    <form action="./login.php" method="POST">
      <div class="mb-3">
        <label for="correo" class="form-label">Correo electrónico</label>
        <input type="email" class="form-control" id="correo" name="correo" required placeholder="ejemplo@itla.edu.dox">
      </div>

      <div class="mb-3">
        <label for="clave" class="form-label">Contraseña</label>
        <input type="password" class="form-control" id="passwd" name="passwd" required placeholder="••••••••">
      </div>

      <div class="d-grid">
        <button type="submit" class="btn btn-primary">Ingresar</button>
      </div>

      <div class="text-center mt-3">
        <a href="register.php">¿No tienes cuenta? Regístrate</a>
      </div>
    </form>
  </div>

</body>
</html>

