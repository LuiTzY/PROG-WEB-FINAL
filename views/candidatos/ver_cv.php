<?php


require_once '../../models/candidato.php';

session_start();

// Validar sesión
if (!isset($_SESSION['id_usuario'])) {
    http_response_code(403);
    exit("Acceso no autorizado.");
}

$candidato = new Candidato();

if($_SESSION['tipo_usuario'] == 'empresa'){
    $idCandidato =  $candidato->buscarCandidatoPorId($_GET['id']);
    $datos = $candidato->findByUsuarioId(id_usuario: $idCandidato['id_usuario']);
}
else{
    $idCandidato = $_SESSION['id_usuario']; 
    $datos = $candidato->findByUsuarioId($idCandidato);

}



// Validar si existe el CV
if ($datos && !empty($datos['cv_pdf'])) {
    // Seguridad: limpiar nombre de archivo
    $filename = basename($datos['cv_pdf']);
    $cvPdf = __DIR__ . '/uploads/' . $filename;
    
    if (file_exists($cvPdf)) {
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="cv.pdf"');
        header('Content-Length: ' . filesize($cvPdf));

        readfile($cvPdf);
        exit;
    } else {
        http_response_code(404);
        exit("El archivo no existe.");
    }

} else {
    http_response_code(404);
    exit("CV no disponible.");
}
