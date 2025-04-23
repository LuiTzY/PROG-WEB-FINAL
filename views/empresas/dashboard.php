<?php
    require_once '../../models/empresa.php';

  session_start();

  $empresa = new Empresa();

  $data = $empresa->obtenerEmpresa($_SESSION['id_usuario']);

  if ($data) {
    // Aquí puedes cargar la información de la empresa en variables para mostrarla en el dashboard
    $id_empresa = $data['id'];
    $nombre_empresa = $data['nombre_empresa'];
    $direccion = $data['direccion'];
    $contacto = $data['contacto'];


    #Obtenemos la cantidad de ofertas que tiene la empresa
    $ofertas = $empresa->obtenerOfertasPorEmpresa($id_empresa);
    
    // Contamos la cantidad de ofertas
    $total_ofertas = is_array($ofertas) ? count($ofertas) : 0;


    $aplicaciones = $empresa->obtenerAplicacionesPorEmpresa($id_empresa);
    $total_aplicaciones = is_array($aplicaciones) ? count($aplicaciones) : 0;
    } 
 
  

  //Aqui deberiamos de cargar toda la info a mostrar de la empresa

  //Verficamos si el tipo de usuario es empresa
  if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'empresa') {
    //Redireccionamos al login
    header("Location: ../usuarios/log_user_as.php");
    //En vez de hacer un echo, colocamos un mensaje de alerta a donde vamos a redireccioanr, es decir en los datos de la session
    exit();
}

  $message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : null;
  $error   = isset($_GET['error'])   ? htmlspecialchars($_GET['error'])   : null;

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de la Empresa</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap + Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background-color: #f1f4f9;
    }
    .dashboard-container {
      max-width: 1000px;
      margin: 50px auto;
      padding: 20px;
    }
    .card-hover:hover {
      transform: translateY(-3px);
      transition: all 0.2s ease-in-out;
    }
  </style>
</head>
<body>

<div class="dashboard-container">
  <h2 class="text-center text-primary mb-4">🏢 Panel de Control <?= $nombre_empresa ?> </h2>
  <p class="text-center text-muted">Bienvenido al centro de gestión de talento de WEB JOBS. Aquí podrás ver y administrar tus ofertas de empleo.</p>


  <?php if ($message): ?>
    <div class="alert alert-success text-center"><?= $message ?></div>
  <?php endif; ?>

  <?php if ($error): ?>
    <div class="alert alert-danger text-center"><?= $error ?></div>
  <?php endif; ?>

  
  <!-- Resumen Rápido -->
  <div class="row text-center mb-4">
    <div class="col-md-4 mb-3">
      <div class="card p-3 shadow-sm card-hover">
        <div class="card-body">
          <i class="bi bi-megaphone fs-2 text-primary mb-2"></i>
          <h5 class="card-title">Ofertas Publicadas</h5>
          <p class="card-text fs-4 fw-bold"><?= $total_ofertas?></p>
          <a href="./ofertas/ofertas.php" class="btn btn-primary">Ver</a>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <div class="card p-3 shadow-sm card-hover">
        <div class="card-body">
          <i class="bi bi-person-check fs-2 text-success mb-2"></i>
          <h5 class="card-title">Aplicaciones Recibidas</h5>
          <p class="card-text fs-4 fw-bold"><?= $total_aplicaciones ?></p>
          <a href="./ofertas/aplicantes.php" class="btn btn-success">Ver</a>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <div class="card p-3 shadow-sm card-hover">
        <div class="card-body">
          <i class="bi bi-plus-square fs-2 text-warning mb-2"></i>
          <h5 class="card-title">Nueva Oferta</h5>
          <a href="ofertas/registrar_ofertas.php" class="btn btn-outline-warning btn-sm mt-2">Publicar ahora</a>
        </div>
      </div>
    </div>
  </div>

  <h4 class="mb-3">📬 Aplicaciones Recientes</h4>
<div class="list-group mb-4">
  <?php if (!empty($aplicaciones)): ?>
    <?php foreach ($aplicaciones as $app): ?>
      <a href="listar_aplicantes.php?id_oferta=<?= $app['id_oferta'] ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
        <div>
          <h6 class="mb-0"><?= htmlspecialchars($app['nombre'] . ' ' . $app['apellido']) ?> aplicó a <strong><?= htmlspecialchars($app['titulo']) ?></strong></h6>
          <small class="text-muted">Aplicado el <?= date("d/m/Y", strtotime($app['fecha_aplicacion'])) ?></small>
        </div>
        <span class="badge bg-primary rounded-pill">Ver</span>
      </a>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="alert alert-info text-center mb-0">
      No se han recibido aplicaciones aún.
    </div>
  <?php endif; ?>
</div>

  <!-- Acciones -->
  <div class="text-center mt-4">
  <a href="../usuarios/logout.php" class="btn btn-outline-danger">Cerrar sesión</a>
</div>
</div>

</body>
</html>
