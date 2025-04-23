<?php
require_once '../../models/candidato.php';

session_start();
$idCandidato = $_SESSION['id_usuario']; 

$candidato = new Candidato();
$datos = $candidato->findByUsuarioId($idCandidato);

if ($datos && !empty($datos['cv_pdf'])) {
    $cvPdf = '../uploads/cv/' . $datos['cv_pdf']; // asegúrate de usar la carpeta correcta
    header('Content-Type: application/pdf');
    readfile($cvPdf);
    exit;
} else {
    echo "CV no disponible.";
}
