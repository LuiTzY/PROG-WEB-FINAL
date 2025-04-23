<?php
    require_once __DIR__ . '/../config/db.php';

class Empresa {
    private $conn;

    // ✅ Constructor que establece la conexión
    public function __construct() {
        $this->conn = conectarDB();
    }

    // ✅ Buscar si el usuario es empresa
    public function findByUsuarioId($id_usuario) {
        $query = "SELECT * FROM empresas WHERE id_usuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        
        $resultado = $stmt->get_result();
        return ($resultado->num_rows > 0) ? $resultado->fetch_assoc() : null;
    }

    // ✅ Crear empresa (cuando un usuario se registra como empresa)
    public function crearEmpresa($id_usuario, $datos) {
        $query = "INSERT INTO empresas (id_usuario, nombre_empresa, direccion, contacto) 
                  VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            "isss",
            $id_usuario,
            $datos['nombre_empresa'],
            $datos['direccion'],
            $datos['contacto']
        );

        return $stmt->execute();
    }

    // ✅ Actualizar información de la empresa
    public function actualizarEmpresa($id_usuario, $datos) {
        $query = "UPDATE empresas SET 
                    nombre_empresa = ?, 
                    direccion = ?, 
                    contacto = ? 
                  WHERE id_usuario = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            "sssi",
            $datos['nombre_empresa'],
            $datos['direccion'],
            $datos['contacto'],
            $id_usuario
        );

        return $stmt->execute();
    }

    // ✅ Obtener datos completos de la empresa
    public function obtenerEmpresa($id_usuario) {
        $query = "SELECT * FROM empresas WHERE id_usuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();

        $resultado = $stmt->get_result();
        return ($resultado->num_rows > 0) ? $resultado->fetch_assoc() : null;
    }

 
  // ✅ Obtener todas las ofertas publicadas por una empresa
  public function obtenerOfertasPorEmpresa($id_empresa) {
    $query = "SELECT * FROM ofertas WHERE id_empresa = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("i", $id_empresa);
    $stmt->execute();

    $resultado = $stmt->get_result();
    return $resultado->fetch_all(MYSQLI_ASSOC);
}

// ✅ Obtener candidatos que aplicaron a una oferta específica
public function obtenerAplicacionesPorOferta($id_oferta) {
    
    if ($id_oferta == 0) {
        return []; // Retornar un array vacío si el ID no es numérico
    }

    $query = "SELECT c.id, c.nombre, c.apellido, a.fecha_aplicacion 
              FROM aplicaciones a
              JOIN candidatos c ON a.id_candidato = c.id
              WHERE a.id_oferta = ?";
    
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("i", $id_oferta);
    $stmt->execute();

    $resultado = $stmt->get_result();
    return $resultado->fetch_all(MYSQLI_ASSOC);
}


public function obtenerAplicacionesPorEmpresa($id_empresa) {
    $query = "
        SELECT 
            aplicaciones.fecha_aplicacion,
            candidatos.nombre,
            candidatos.apellido,
            ofertas.titulo,
            ofertas.id AS id_oferta,
            candidatos.id AS id_candidato
        FROM aplicaciones
        JOIN ofertas ON aplicaciones.id_oferta = ofertas.id
        JOIN candidatos ON aplicaciones.id_candidato = candidatos.id
        WHERE ofertas.id_empresa = ?
        ORDER BY aplicaciones.fecha_aplicacion DESC
    ";

    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("i", $id_empresa);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}
// ✅ Crear una nueva oferta de empleo
public function crearOferta($id_empresa, $datos) {
    $query = "INSERT INTO ofertas (id_empresa, titulo, descripcion, requisitos, fecha_creacion) 
              VALUES (?, ?, ?, ?, CURRENT_DATE)";

    $stmt = $this->conn->prepare($query);
    $stmt->bind_param(
        "isss",
        $id_empresa,
        $datos['titulo'],
        $datos['descripcion'],
        $datos['requisitos']
    );

    return $stmt->execute();
}

    // ✅ Actualizar una oferta
    public function actualizarOferta($id_oferta, $datos) {
        $query = "UPDATE ofertas SET 
                    titulo = ?, 
                    descripcion = ?, 
                    requisitos = ? 
                WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            "sssi",
            $datos['titulo'],
            $datos['descripcion'],
            $datos['requisitos'],
            $id_oferta
        );

        return $stmt->execute();
    }

    // ✅ Eliminar una oferta
    public function eliminarOferta($id_oferta) {
        $query = "DELETE FROM ofertas WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_oferta);

        return $stmt->execute();
    }
 
    public function obtenerOferta($id_oferta) {
        $query = "SELECT * FROM ofertas WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_oferta);
        $stmt->execute();

        $resultado = $stmt->get_result();
        return ($resultado->num_rows > 0) ? $resultado->fetch_assoc() : null;
    }

}
?>
