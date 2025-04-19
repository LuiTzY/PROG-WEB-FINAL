<?php
session_start();
require_once '../../../models/empresa.php';

$empresaModel = new Empresa();
$id_usuario = $_SESSION['id_usuario'];
$empresa = $empresaModel->obtenerEmpresa($id_usuario);
$id_empresa = $empresa['id'];

$ofertas = $empresaModel->obtenerOfertasPorEmpresa($id_empresa);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Mis Ofertas Publicadas</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f8f9fa;
    }
    .container-table {
      max-width: 1000px;
      margin: 50px auto;
    }
  </style>
</head>
<body>

<div class="container-table">
  <h2 class="text-center text-primary mb-4">📄 Mis Ofertas Publicadas</h2>

  <?php if (!empty($ofertas)): ?>
    <table id="tablaOfertas" class="table table-striped table-bordered shadow-sm bg-white">
      <thead class="table-light">
        <tr>
          <th>Título</th>
          <th>Fecha de Publicación</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($ofertas as $oferta): ?>
          <tr>
            <td><?= htmlspecialchars($oferta['titulo']) ?></td>
            <td><?= date("d/m/Y", strtotime($oferta['fecha_creacion'])) ?></td>
            <td>
              <a href="listar_aplicantes.php?id_oferta=<?= $oferta['id'] ?>" class="btn btn-sm btn-primary me-1">Ver Aplicantes</a>
              <a href="editar_oferta.php?id=<?= $oferta['id'] ?>" class="btn btn-sm btn-warning me-1">Editar</a>
              <a href="eliminar_oferta.php?id=<?= $oferta['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta oferta?')">Eliminar</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <div class="alert alert-info text-center">
      No has publicado ninguna oferta aún. <a href="registrar_ofertas.php">Publica la primera aquí</a>.
    </div>
  <?php endif; ?>

  <div class="text-center mt-4">
    <a href="../dashboard.php" class="btn btn-outline-secondary">⬅️ Volver al Panel</a>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
  $(document).ready(function () {
    $('#tablaOfertas').DataTable({
      language: {
        search: "Buscar:",
        lengthMenu: "Mostrar _MENU_ ofertas",
        info: "Mostrando _START_ a _END_ de _TOTAL_ ofertas",
        paginate: {
          next: "Siguiente",
          previous: "Anterior"
        },
        zeroRecords: "No se encontraron resultados"
      }
    });
  });
</script>

</body>
</html>
