<?php 
 
 require_once '../../../models/empresa.php';
 session_start();
 
 $empresa =  new Empresa();

 if(!isset($_GET['id'])){
    header('Location: ofertas.php?error=ID de oferta no proporcionado');
    exit();
 }

 //como sabemos que tenemos el id de la oferta, procedemos a eliminarla
  $ofertaEliminada = $empresa->eliminarOferta($_GET['id']);

  //verfificamos si se elimino la oferta
  if($ofertaEliminada){
        header('Location: ../dashboard.php?message=Oferta eliminada correctamente');
    }
    else{

        header('Location: ../dashboard.php?error=No se ha podido eliminar la oferta');
        exit();

    }
    //si no se elimino la oferta, redireccionamos a la pagina de ofertas con un mensaje de error
    
?>