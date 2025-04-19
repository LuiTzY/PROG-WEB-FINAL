<?php
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Candidato.php';
require_once __DIR__ . '/../models/Empresa.php';

// ✅ LOGIN DEL USUARIO
        function login() {
            session_start();
            $correo = $_POST['correo'];
            $clave = $_POST['passwd'];

            $usuario = new Usuario();
            $data = $usuario->findByCorreo($correo);

            if ($data && password_verify($clave, $data['passwd'])) {
                $_SESSION['id_usuario'] = $data['id'];

                //  Verificar si es candidato o empresa
                if (esCandidato($data['id'])) {
                    $_SESSION['tipo_usuario'] = 'candidato';
                    header("Location: ./candidatos/dashboard.php");
                    //Nota: para poder acceder a la info de las sesiones, debemos de acabar esta, para poder incrustar los datos correctamente
                    exit();

                } 
                
                elseif (esEmpresa($data['id'])) {
                    $_SESSION['tipo_usuario'] = 'empresa';
                    header("Location: ../empresas/dashboard.php");
                     //Nota: para poder acceder a la info de las sesiones, debemos de acabar esta, para poder incrustar los datos correctamente
                     exit();
                }
                
                else {
                    // No está ni en candidatos ni en empresas
                    echo "<script>alert('No tas relacionada con nada.');</script>";

                    header("Location: ./log_user_as.php");
                    echo "<script>alert('No tiene un rol asignado.');</script>";
                    echo "Error: No tiene un rol asignado.";


                    //aqui se debe de redirigir con un mensaje de que no tiene nada
                }
                // exit();
            } else {

                //alerta para mostrar cuando es invalido
                echo "Correo o contraseña inválidos.";
            }
        }

        function esCandidato($id_usuario) {
            $candidato = new Candidato();
            $data = $candidato->findByUsuarioId($id_usuario);
            return !empty($data); // Si hay resultado, es candidato
        }

        function esEmpresa($id_usuario) {
            $empresa = new Empresa();
            $data = $empresa->findByUsuarioId($id_usuario);
            return !empty($data); // Si hay resultado, es empresa
        }

        function logout() {
            session_start();
            session_destroy();
            header("Location: ../usuarios/login.php");
            exit();
        }
            

?>
