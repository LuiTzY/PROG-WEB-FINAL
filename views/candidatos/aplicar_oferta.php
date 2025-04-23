<?php
session_start();
require_once '../../models/Candidato.php';



$id_usuario = $_SESSION['id_usuario'];
$id_oferta = intval($_GET['id']);

$candidatoModel = new Candidato();
$candidato = $candidatoModel->findByUsuarioId($id_usuario);



$id_candidato = $candidato['id'];
$resultado = $candidatoModel->aplicarOferta($id_candidato, $id_oferta);

if ($resultado === true) {
    header("Location: ../../views/candidatos/ofertas.php?message=Aplicación realizada correctamente");
} else {
    header("Location: ../../views/candidatos/ofertas.php?error=No Pudiste aplicar a la oferta" . urlencode($resultado));
}
exit();
