<?php
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Candidato.php';
require_once __DIR__ . '/../models/Empresa.php';

// ✅ LOGIN DEL USUARIO
        function login() {
            session_start();
            $correo = $_POST['correo'];
            $clave = $_POST['clave'];

            $usuario = new Usuario();
            $data = $usuario->findByCorreo($correo);

            if ($data && password_verify($clave, $data['contraseña'])) {
                $_SESSION['id_usuario'] = $data['id'];

                // 🔎 Verificar si es candidato o empresa
                if (esCandidato($data['id'])) {
                    $_SESSION['tipo_usuario'] = 'candidato';
                    header("Location: ../views/candidato/dashboard.php");
                } elseif (esEmpresa($data['id'])) {
                    $_SESSION['tipo_usuario'] = 'empresa';
                    header("Location: ../views/empresa/dashboard.php");
                } else {
                    // No está ni en candidatos ni en empresas
                    echo "Error: No tiene un rol asignado.";


                    //aqui se debe de redirigir con un mensaje de que no tiene nada
                }
                exit();
            } else {

                //alerta para mostrar cuando es invalido
                echo "Correo o contraseña inválidos.";
            }
        }

        // ✅ FUNCIONES PARA VERIFICAR ROLES
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

        // ✅ LOGOUT: Cerrar sesión
        function logout() {
            session_start();
            session_destroy();
            header("Location: ../views/auth/login.php");
            exit();
        }
            

?>
