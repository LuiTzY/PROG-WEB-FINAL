<?php
session_start();
require_once '../../../models/empresa.php';

$empresaModel = new Empresa();
$id_usuario = $_SESSION['id_usuario'];
$empresa = $empresaModel->obtenerEmpresa($id_usuario);
$id_empresa = $empresa['id'];
$aplicaciones = $empresaModel->obtenerAplicacionesPorEmpresa($id_empresa);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Todos los Aplicantes</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6f8;
    }
    .container-aplicantes {
      max-width: 1000px;
      margin: 50px auto;
      background: #fff;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
  </style>
</head>
<body>

<div class="container-aplicantes">
  <h2 class="text-center text-primary mb-4">📋 Todos los Aplicantes</h2>

  <?php if (!empty($aplicaciones)): ?>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Candidato</th>
          <th>Oferta</th>
          <th>Fecha de Aplicación</th>
          <th>Acción</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($aplicaciones as $app): ?>
          <tr>
            <td><?= htmlspecialchars($app['nombre']) . ' ' . htmlspecialchars($app['apellido']) ?></td>
            <td><?= htmlspecialchars($app['titulo']) ?></td>
            <td><?= date("d/m/Y", strtotime($app['fecha_aplicacion'])) ?></td>
            <td>
              <a href="../../candidatos/ver_cv.php?id=<?= $app['id_candidato'] ?>" class="btn btn-sm btn-outline-primary">Ver CV</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <div class="alert alert-info text-center">No hay aplicaciones registradas aún.</div>
  <?php endif; ?>

  <div class="text-center mt-4">
    <a href="../dashboard.php" class="btn btn-outline-secondary">⬅️ Volver al Panel</a>
  </div>
</div>

</body>
</html>
