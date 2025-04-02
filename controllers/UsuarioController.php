<?php
    require_once '../models/usuario.php';
    require_once '../config/db.php';

class UsuarioController {
    private $usuarioModel;

    public function __construct($db){
        $this->usuarioModel = new Usuario($db);
    }

    public function registar() {
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $correo = $_POST["correo"];
            $passwd = $_POST["passwd"];

            if ($this->usuarioModel->crear_usuario($correo, $passwd)) {
                header("Location: ../views/usuarios/login.php");
                exit();
            } else{
                echo"Error al registrar usuario.";
            }

        }
    }
}
$db = conectarDB();
$controller = new UsuarioController($db);
$controller->registar();
?>