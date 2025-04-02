<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
</head>
<body>
    <h1>Registrarse</h1>
<form action="register.php" method="POST">
        <label for="nombre">Nombre</label><br>
        <input type="text" name="nombre" required><br>
        <label for="apellido">Apellido</label><br>
        <input type="text" name="apellido" required><br>
        <label for="telefono">Telefono</label><br>
        <input type="text" name="telefono" required><br>
        <label for="direccion">Direccion</label><br>
        <input type="text" name="direccion" required><br>
        <label for="ciudad">Ciudad</label><br>
        <input type="text" name="ciudad" required><br>
        <label for="resumen">Resumen</label><br>
        <input type="text" name="resumen" required><br>
        <label for="disponibilidad">Disponibilidad</label><br>
        <input type="text" name="disponibilidad" required><br>
        <label for="habilidades">Habilidades</label><br>
        <input type="text" name="habilidades" required><br>
        <label for="idiomas">Idiomas</label><br>
        <input type="text" name="idiomas" required><br>
        <label for="redes_profesionales">Redes Profesionales</label><br>
        <input type="text" name="redes_profesionales" required><br>
        <label for="referencias">Referencias</label><br>
        <input type="text" name="referencias" required><br>
        <label for="foto">Foto</label><br>
        <input type="text" placeholder="Copie el link aqui" name="foto" required><br>
        <label for="cv">CV</label><br>
        <input type="text" placeholder="Copie el link de descarga aqui" name="cv" required>
    </form>
</body>
</html>