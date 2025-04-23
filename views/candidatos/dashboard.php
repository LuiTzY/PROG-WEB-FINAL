<?php
/*
session_start();

echo $_SESSION['tipo_usuario'];
*/
session_start();

$candidate_name = isset($_SESSION['candidate_name']) ? $_SESSION['candidate_name'] : 'Candidato';
$last_access_days = isset($_SESSION['last_access_days']) ? $_SESSION['last_access_days'] : 'algunos';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Dashboard del Candidato</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f5f7fa;
    }
    .dashboard-container {
      max-width: 1000px;
      margin: 40px auto;
      padding: 20px;
    }
    .card-icon {
      font-size: 32px;
      color: #0d6efd;
    }
  </style>
</head>
<body>

<div class="dashboard-container">
  <h2 class="mb-4 text-center">👋 Bienvenido, <?= htmlspecialchars($candidate_name) ?></h2>
  <p class="text-center text-muted">Tu último acceso fue hace <?= htmlspecialchars($last_access_days) ?> días. Aprovecha las nuevas oportunidades disponibles para ti.</p>

  <!-- Atajos Rápidos -->
  <div class="row text-center mb-5">
    <div class="col-md-4 mb-3">
      <div class="card p-4 shadow-sm h-100">
        <div class="card-icon mb-2">📄</div>
        <h5 class="card-title">Ver mi CV</h5>
        <p class="card-text text-muted">Revisa o descarga tu hoja de vida.</p>
        <a href="ver_cv.php" class="btn btn-outline-primary btn-sm">Ver CV</a>
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <div class="card p-4 shadow-sm h-100">
        <div class="card-icon mb-2">🔎</div>
        <h5 class="card-title">Buscar Ofertas</h5>
        <p class="card-text text-muted">Explora nuevas oportunidades laborales.</p>
        <a href="buscar_ofertas.php" class="btn btn-outline-success btn-sm">Ver Ofertas</a>
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <div class="card p-4 shadow-sm h-100">
        <div class="card-icon mb-2">📬</div>
        <h5 class="card-title">Mis Aplicaciones</h5>
        <p class="card-text text-muted">Consulta las ofertas a las que te has postulado.</p>
        <a href="mis_aplicaciones.php" class="btn btn-outline-warning btn-sm">Ver Aplicaciones</a>
      </div>
    </div>
  </div>

  <!-- Últimas Ofertas -->
  <h4 class="mb-3">🆕 Últimas Ofertas Publicadas</h4>
  <div class="list-group mb-5">
    <a href="detalle_oferta.php?id=1" class="list-group-item list-group-item-action">
      <div class="d-flex w-100 justify-content-between">
        <h5 class="mb-1">Desarrollador Web Jr.</h5>
        <small>Hace 1 día</small>
      </div>
      <p class="mb-1">Empresa: TecnoSoft RD · Ubicación: Santo Domingo</p>
      <small>Requiere HTML, CSS, PHP, MySQL.</small>
    </a>
    <a href="detalle_oferta.php?id=2" class="list-group-item list-group-item-action">
      <div class="d-flex w-100 justify-content-between">
        <h5 class="mb-1">Diseñador Gráfico Freelance</h5>
        <small>Hace 2 días</small>
      </div>
      <p class="mb-1">Empresa: Creativa Studio · Ubicación: Remoto</p>
      <small>Requiere manejo de Adobe Illustrator y Figma.</small>
    </a>
    <a href="detalle_oferta.php?id=3" class="list-group-item list-group-item-action">
      <div class="d-flex w-100 justify-content-between">
        <h5 class="mb-1">Asistente Administrativo</h5>
        <small>Hace 3 días</small>
      </div>
      <p class="mb-1">Empresa: Inversiones López · Ubicación: Santiago</p>
      <small>Requiere experiencia básica en oficina y Excel.</small>
    </a>
  </div>

  <!-- Cerrar sesión -->
  <div class="text-center">
    <a href="../usuarios/logout.php" class="btn btn-outline-danger">Cerrar sesión</a>
  </div>
</div>

</body>
</html>