<?php
session_start();
require_once '../../../models/empresa.php';

// Validar que se haya recibido el ID de la oferta
if (!isset($_GET['id_oferta']) || !is_numeric($_GET['id_oferta'])) {
    echo "<div class='alert alert-danger text-center m-5'>ID de oferta no válido. No puedes acceder directamente a esta página.</div>";
    exit();
}

$id_oferta = intval($_GET['id_oferta']);

$empresaModel = new Empresa();
$aplicantes = $empresaModel->obtenerAplicacionesPorOferta($id_oferta); // Debes tener este método

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Aplicantes de la Oferta</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .container-aplicantes {
      max-width: 900px;
      margin: 60px auto;
      background: #fff;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
  </style>
</head>
<body>

<div class="container-aplicantes">
  <h2 class="text-center text-primary mb-4">📬 Aplicantes</h2>

  <?php if (!empty($aplicantes)): ?>
    <ul class="list-group mb-4">
      <?php foreach ($aplicantes as $app): ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <div>
            <h6 class="mb-1"><?= htmlspecialchars($app['nombre']) . ' ' . htmlspecialchars($app['apellido']) ?></h6>
            <small class="text-muted">Aplicó el <?= date("d/m/Y", strtotime($app['fecha_aplicacion'])) ?></small>
          </div>
          <a href="../candidatos/ver_cv.php?id=<?= $app['id_candidato'] ?>" class="btn btn-sm btn-outline-primary">Ver Perfil</a>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <div class="alert alert-info text-center">
      Esta oferta aún no ha recibido aplicaciones.
    </div>
  <?php endif; ?>

  <div class="text-center mt-4">
    <a href="ofertas.php" class="btn btn-outline-secondary">⬅️ Volver al listado de ofertas</a>
  </div>
</div>

</body>
</html>
