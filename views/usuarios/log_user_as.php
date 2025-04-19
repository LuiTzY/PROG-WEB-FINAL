
<?php 

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>¿Qué deseas ser?</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6f8;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .choose-card {
      background: white;
      padding: 2rem;
      border-radius: 12px;`
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      text-align: center;
      max-width: 500px;
      width: 100%;
    }
    .btn-option {
      margin-top: 1rem;
    }
  </style>
</head>
<body>

  <div class="choose-card">
    <h2 class="mb-4">¿Cómo deseas registrarte?</h2>
    <p>Elige el tipo de cuenta que deseas completar para continuar:</p>
    <div class="d-grid gap-3 mt-4">
      <a href="../candidatos/register.php" class="btn btn-outline-primary btn-option">👤 Soy Candidato</a>
      <a href="../empresas/register.php" class="btn btn-outline-success btn-option">🏢 Soy Empresa</a>
    </div>
  </div>

</body>
</html>
