<?php
session_start();
require_once '../../models/Candidato.php';

$candidatoModel = new Candidato();
$id_usuario = $_SESSION['id_usuario'];
$candidato = $candidatoModel->findByUsuarioId($id_usuario);

if (!$candidato) {
    echo "Candidato no válido.";
    exit();
}

$id_candidato = $candidato['id'];
$aplicaciones = $candidatoModel->obtenerMisAplicaciones($id_candidato);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Mis Aplicaciones</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f7f9fc;
    }
    .aplicacion-card {
      background: #fff;
      padding: 1.5rem;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      margin-bottom: 1.5rem;
    }
  </style>
</head>
<body>

<div class="container my-5">
  <h2 class="text-center text-primary mb-4">📄 Mis Aplicaciones</h2>

  <?php if (!empty($aplicaciones)): ?>
    <?php foreach ($aplicaciones as $app): ?>
      <div class="aplicacion-card">
        <h5 class="mb-1"><?= htmlspecialchars($app['titulo']) ?></h5>
        <p class="text-muted mb-1">📍 Empresa: <strong><?= htmlspecialchars($app['nombre_empresa']) ?></strong></p>
        <p>📅 Aplicaste el: <?= date("d/m/Y", strtotime($app['fecha_aplicacion'])) ?></p>
        <a href="detalle_oferta.php?id=<?= $app['id_oferta'] ?>" class="btn btn-outline-primary btn-sm">Ver Oferta</a>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="alert alert-info text-center">
      Aún no has aplicado a ninguna oferta.
    </div>
  <?php endif; ?>

  <div class="text-center mt-4">
    <a href="dashboard.php" class="btn btn-outline-secondary">⬅️ Volver al Panel</a>
  </div>
</div>

</body>
</html>
