<?php
session_start();
require_once '../../models/candidato.php';

$id_usuario = $_SESSION['id_usuario'];

$candidatoModel = new Candidato();

$candidatoData = $candidatoModel->obtenerCandidato($id_usuario);
$ofertas = $candidatoModel->obtenerOfertasDisponibles();

$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : null;
$error   = isset($_GET['error'])   ? htmlspecialchars($_GET['error'])   : null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Ofertas Disponibles</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f9f9fb;
    }
    .oferta-card {
      background: #fff;
      border-radius: 12px;
      padding: 1.5rem;
      box-shadow: 0 6px 12px rgba(0,0,0,0.05);
      margin-bottom: 1.5rem;
    }
  </style>
</head>
<body>

<div class="container my-5">
  <h2 class="text-center text-primary mb-4">🔍 Ofertas Disponibles para Ti</h2>
  <?php if ($message): ?>
    <div class="alert alert-success text-center"><?= $message ?></div>
  <?php endif; ?>

  <?php if ($error): ?>
    <div class="alert alert-danger text-center"><?= $error ?></div>
  <?php endif; ?>


  <?php if (!empty($ofertas)): ?>
    <?php foreach ($ofertas as $oferta): ?>
      <div class="oferta-card">
        <h5 class="mb-1"><?= htmlspecialchars($oferta['titulo']) ?></h5>
        <p class="text-muted mb-1">Empresa de la oferta: <strong> <?= htmlspecialchars($oferta['nombre_empresa']) ?> </strong></p>
        <p><strong>Descripcion:</strong> <?= htmlspecialchars($oferta['descripcion']) ?></p>
        <p><strong>Requisitos:</strong> <?= htmlspecialchars($oferta['requisitos']) ?></p>
        
        <?php if ($candidatoModel->yaHaAplicado($candidatoData['id'], $oferta['id'])): ?>
          <p class="text-danger">Ya has aplicado a esta oferta.</p>
          <a href="retirar_aplicacion.php?id=<?= $oferta['id'] ?>" class="btn btn-warning btn-sm">Retirar aplicacion</a>
        <?php else: ?>
          <a href="aplicar_oferta.php?id=<?= $oferta['id'] ?>" class="btn btn-success btn-sm">Aplicar Oferta</a>
        <?php endif; ?>

      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="alert alert-info text-center">
      No hay ofertas disponibles por el momento.
    </div>
  <?php endif; ?>

  <div class="text-center mt-4">
    <a href="dashboard.php" class="btn btn-outline-secondary">⬅️ Volver al Panel</a>
  </div>
</div>

</body>
</html>
