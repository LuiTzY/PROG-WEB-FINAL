<?php

require_once 'Candidato.php';
$candidato = new Candidato();
$id_usuario = $_SESSION['id_usuario']; // Asumiendo que el ID del usuario está en la sesión
$datos = $_POST; // Recoger otros datos del formulario

if ($candidato->crearCandidato($id_usuario, $datos)) {
    header("Location: ./login.php");
    exit();
} else {
    echo "Error al crear el candidato.";
}

?>