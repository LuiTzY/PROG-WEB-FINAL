<?php
require_once __DIR__ . '/../config/db.php';

class Candidato {
    private $conn;

    // ✅ Constructor que establece la conexión
    public function __construct() {
        $this->conn = conectarDB();
    }

    // ✅ Buscar si el usuario es candidato
    public function findByUsuarioId($id_usuario) {
        $query = "SELECT * FROM candidatos WHERE id_usuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        
        $resultado = $stmt->get_result();
        return ($resultado->num_rows > 0) ? $resultado->fetch_assoc() : null;
    }

    // ✅ Crear candidato (cuando un usuario se registra como candidato)
    public function crearCandidato($id_usuario, $datos) {
        $query = "INSERT INTO candidatos (id_usuario, nombre, apellido, telefono, direccion, ciudad, resumen, disponibilidad, habilidades, idiomas, redes_profesionales, referencias, foto, cv_pdf) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            "isssssssssssss",
            $id_usuario,
            $datos['nombre'],
            $datos['apellido'],
            $datos['telefono'],
            $datos['direccion'],
            $datos['ciudad'],
            $datos['resumen'],
            $datos['disponibilidad'],
            $datos['habilidades'],
            $datos['idiomas'],
            $datos['redes_profesionales'],
            $datos['referencias'],
            $datos['foto'],
            $datos['cv_pdf']
        );

        return $stmt->execute();
    }

    // ✅ Actualizar información del candidato
    public function actualizarCandidato($id_usuario, $datos) {
        $query = "UPDATE candidatos SET 
                    nombre = ?, 
                    apellido = ?, 
                    telefono = ?, 
                    direccion = ?, 
                    ciudad = ?, 
                    resumen = ?, 
                    disponibilidad = ?, 
                    habilidades = ?, 
                    idiomas = ?, 
                    redes_profesionales = ?, 
                    referencias = ?, 
                    foto = ?, 
                    cv_pdf = ? 
                  WHERE id_usuario = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            "sssssssssssssi",
            $datos['nombre'],
            $datos['apellido'],
            $datos['telefono'],
            $datos['direccion'],
            $datos['ciudad'],
            $datos['resumen'],
            $datos['disponibilidad'],
            $datos['habilidades'],
            $datos['idiomas'],
            $datos['redes_profesionales'],
            $datos['referencias'],
            $datos['foto'],
            $datos['cv_pdf'],
            $id_usuario
        );

        return $stmt->execute();
    }

    // ✅ Obtener datos completos del candidato
    public function obtenerCandidato($id_usuario) {
        $query = "SELECT * FROM candidatos WHERE id_usuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();

        $resultado = $stmt->get_result();
        return ($resultado->num_rows > 0) ? $resultado->fetch_assoc() : null;
    }

}
?>
