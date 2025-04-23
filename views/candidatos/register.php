<?php
require_once '../../models/candidato.php';

$candidato = new Candidato();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    $user_id = $_SESSION['id_usuario'];
    
    
    //Carpeta donde va a ser subido los pdfs
    $uploadDir = 'uploads/';
    
    

    $file = $_FILES['cv_pdf'];

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $newFileName = 'cv_' . $user_id . '_' . uniqid() . '.pdf';
    $uploadFile = $uploadDir . $newFileName;

    if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
        $_POST['cv_pdf'] = $uploadFile;
        $candidato_creado = $candidato->crearCandidato($user_id, $_POST);
    } 
    else{
        echo "<script>alert('no se guardo na')</script>";
    }
        
    }
    
    if ($candidato_creado) {
        $infoCandidato = $candidato->findByUsuarioId($user_id); 

        if ($infoCandidato) {
            $_SESSION['candidate_name'] = $infoCandidato['nombre'];

            // Actualizar último acceso (esto guardará la fecha/hora actual)
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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Candidato</title>
</head>
<body>
    <h1>Registrarse</h1>


<form id="form" action="register.php" method="POST"  enctype="multipart/form-data" >
    <label for="nombre">Nombre</label><br>
    <input type="text" name="nombre" required><br>
    
    <label for="apellido">Apellido</label><br>
    <input type="text" name="apellido" required><br>
    
    <label for="telefono">Telefono</label><br>
    <input type="tel" name="telefono" required><br>
    
    <label for="direccion">Direccion</label><br>
    <input type="text" name="direccion" required><br>
    
    <label for="ciudad">Ciudad</label><br>
    <input type="text" name="ciudad" required><br>
    
    <label for="resumen">Resumen</label><br>
    <textarea name="resumen" required></textarea><br>
    
    <label for="disponibilidad">Disponibilidad</label><br>
    <select name="disponibilidad" required>
        <option value="">Seleccione...</option>
        <option value="tiempo_completo">Tiempo completo</option>
        <option value="medio_tiempo">Medio tiempo</option>
        <option value="freelance">Freelance</option>
    </select><br>
    
    <label for="habilidades">Habilidades</label><br>
    <textarea name="habilidades" required></textarea><br>
    
    <label for="idiomas">Idiomas</label><br>
    <input type="text" name="idiomas" required><br>
    
    <label for="redes_profesionales">Redes Profesionales</label><br>
    <input type="url" name="redes_profesionales" placeholder="https://ejemplo.com"><br>
    
    <label for="referencias">Referencias</label><br>
    <textarea name="referencias" required></textarea><br>
    
    <label for="foto">Foto</label><br>
    <input type="url" placeholder="Copie el link aqui" name="foto" required><br>
    
    <label for="cv_pdf">CV</label><br>
    <input type="file" name="cv_pdf" id="cv_pdf" accept="application/pdf" required>
    <button type="submit">Enviar</button>
</form>

</body>
</html>