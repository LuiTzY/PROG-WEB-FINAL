<?php
session_start();
require_once '../../models/candidato.php';


$id_usuario = $_SESSION['id_usuario'];
$id_oferta = intval($_POST['id_oferta']);

$candidatoModel = new Candidato();
$candidato = $candidatoModel->findByUsuarioId($id_usuario);


$id_candidato = $candidato['id'];

if ($candidatoModel->retirarAplicacion($id_candidato, $id_oferta)) {
    header("Location: ./ofertas.php?message=Aplicación cancelada con éxito");
} else {
    header("Location: ./ofertas.php?error=No se pudo cancelar la aplicación");
}
exit();
