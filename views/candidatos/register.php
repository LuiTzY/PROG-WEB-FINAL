<?php
require_once '../../models/candidato.php';

$candidato = new Candidato();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    $user_id = $_SESSION['id_usuario'];
    
    $uploadDir = 'uploads/';
    $file = $_FILES['cv_pdf'];

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $newFileName = 'cv_' . $user_id . '_' . uniqid() . '.pdf';
    $uploadFile = $uploadDir . $newFileName;

    if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
        $_POST['cv_pdf'] = $uploadFile;
    } 
    
    $candidato_creado = $candidato->crearCandidato($user_id, $_POST);

    if ($candidato_creado) {
        $infoCandidato = $candidato->findByUsuarioId($user_id); 
        if ($infoCandidato) {
            $_SESSION['candidate_name'] = $infoCandidato['nombre'];
            $candidato->updateUltimoAcceso($infoCandidato['id']);
            $infoCandidato = $candidato->findByUsuarioId($user_id);
            if (!empty($infoCandidato['ultimo_acceso'])) {
                $ultimaFecha = new DateTime($infoCandidato['ultimo_acceso']);
                $hoy = new DateTime();
                $diferencia = $hoy->diff($ultimaFecha);
                $_SESSION['last_access_days'] = $diferencia->days;
            } else {
                $_SESSION['last_access_days'] = 'N/A';
            }
        }
        header("Location: dashboard.php");
        exit(); 
    } else {
        echo "Error al crear el candidato. Por favor, inténtelo de nuevo.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Candidato</title>
    <style>
        body {
            background-color: #eef1f5;
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: start;
            padding: 40px;
        }

        form {
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 600px;
        }

        h1 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        label {
            display: block;
            margin: 12px 0 6px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="tel"],
        input[type="url"],
        input[type="file"],
        input[type="email"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 15px;
            margin-bottom: 10px;
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007BFF;
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 15px;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<form id="form" action="register.php" method="POST" enctype="multipart/form-data">
    <h1>Registrar Candidato</h1>

    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" required>
    
    <label for="apellido">Apellido</label>
    <input type="text" name="apellido" required>
    
    <label for="telefono">Teléfono</label>
    <input type="tel" name="telefono" required>
    
    <label for="direccion">Dirección</label>
    <input type="text" name="direccion" required>
    
    <label for="ciudad">Ciudad</label>
    <input type="text" name="ciudad" required>
    
    <label for="resumen">Resumen</label>
    <textarea name="resumen" required></textarea>
    
    <label for="disponibilidad">Disponibilidad</label>
    <select name="disponibilidad" required>
        <option value="">Seleccione...</option>
        <option value="tiempo_completo">Tiempo completo</option>
        <option value="medio_tiempo">Medio tiempo</option>
        <option value="freelance">Freelance</option>
    </select>
    
    <label for="habilidades">Habilidades</label>
    <textarea name="habilidades" required></textarea>
    
    <label for="idiomas">Idiomas</label>
    <input type="text" name="idiomas" required>
    
    <label for="redes_profesionales">Redes Profesionales</label>
    <input type="url" name="redes_profesionales" placeholder="https://ejemplo.com">
    
    <label for="referencias">Referencias</label>
    <textarea name="referencias" required></textarea>
    
    <label for="foto">Foto (URL)</label>
    <input type="url" placeholder="Copie el link aquí" name="foto" required>
    
    <label for="cv_pdf">CV (PDF)</label>
    <input type="file" name="cv_pdf" id="cv_pdf" accept="application/pdf" required>
    
    <button type="submit">Enviar</button>
</form>

</body>
</html>
