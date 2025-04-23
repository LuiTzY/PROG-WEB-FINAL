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

    public function buscarCandidatoPorId($id_candidato) {
        $query = "SELECT * FROM candidatos WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_candidato);
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

    public function updateUltimoAcceso($id) {
        $conexion = conectarDB();
    
        $stmt = $conexion->prepare("UPDATE candidatos SET ultimo_acceso = NOW() WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        $stmt->close();
        $conexion->close();
    }



    public function retirarAplicacion($id_candidato, $id_oferta) {
        $query = "DELETE FROM aplicaciones WHERE id_candidato = ? AND id_oferta = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $id_candidato, $id_oferta);
    
        return $stmt->execute();
    }
    
    public function obtenerOfertasDisponibles() {
        $query = "
            SELECT ofertas.*, empresas.nombre_empresa
            FROM ofertas
            JOIN empresas ON ofertas.id_empresa = empresas.id
            ORDER BY fecha_creacion DESC
        ";
    
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $resultado = $stmt->get_result();
    
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerMisAplicaciones($id_candidato) {
        $query = "
            SELECT 
                ofertas.titulo, 
                ofertas.id AS id_oferta,
                empresas.nombre_empresa,
                aplicaciones.fecha_aplicacion
            FROM aplicaciones
            JOIN ofertas ON aplicaciones.id_oferta = ofertas.id
            JOIN empresas ON ofertas.id_empresa = empresas.id
            WHERE aplicaciones.id_candidato = ?
            ORDER BY aplicaciones.fecha_aplicacion DESC
        ";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_candidato);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function aplicarOferta($id_candidato, $id_oferta) {
        // Verificar si ya aplicó
        $query_check = "SELECT id FROM aplicaciones WHERE id_candidato = ? AND id_oferta = ?";
        $stmt_check = $this->conn->prepare($query_check);
        $stmt_check->bind_param("ii", $id_candidato, $id_oferta);
        $stmt_check->execute();
        $stmt_check->store_result();
    
        if ($stmt_check->num_rows > 0) {
            return "Ya has aplicado a esta oferta.";
        }
    
        // Insertar nueva aplicación
        $query = "INSERT INTO aplicaciones (id_candidato, id_oferta) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $id_candidato, $id_oferta);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return "Error al aplicar: " . $stmt->error;
        }
    }


    public function yaHaAplicado($id_candidato, $id_oferta) {
        $query = "SELECT id FROM aplicaciones WHERE id_candidato = ? AND id_oferta = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $id_candidato, $id_oferta);
        $stmt->execute();
        $stmt->store_result();
    
        return $stmt->num_rows > 0;
    }
}
?>
