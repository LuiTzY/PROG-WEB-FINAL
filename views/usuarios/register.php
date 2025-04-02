<?php
    require_once '../../config/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>
<body>
    <h1>Registarse</h1>
<form action="../../controllers/UsuarioController.php" method="POST">
        <label for="correo">Correo:</label><br>
        <input type="email" name="correo" required><br>
        <label for="passwd">Contraseña:</label><br>
        <input type="password" name="passwd" required><br>
        <button type="submit">Registrarse</button>
    </form>
</body>
</body>
</html>