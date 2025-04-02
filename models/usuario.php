
<?php
    require_once __DIR__ . '/../config/db.php'; // Ruta corregida

class Usuario {
    private $conn;

    // Constructor para inicializar la conexión
    public function __construct() {
        $this->conn = conectarDB(); // Llamamos a la función conectarDB()
    }

    // ✅ Buscar usuario por correo
    public function findByCorreo($correo) {
        $query = "SELECT * FROM usuarios WHERE correo = ?";
        $stmt = $this->conn->prepare($query);
        
        // Vincular parámetros y ejecutar
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        
        $resultado = $stmt->get_result();
        
        // Devolver resultado si existe
        return ($resultado->num_rows > 0) ? $resultado->fetch_assoc() : null;
    }

    // ✅ Crear usuario nuevo
    public function crear_usuario($correo, $clave) {
        // Validar si el correo ya existe
        if ($this->findByCorreo($correo)) {
            return "El correo ya está registrado.";
        }

        // Encriptar la contraseña antes de guardarla
        $claveHash = password_hash($clave, PASSWORD_DEFAULT);

        // Query para insertar usuario
        $query = "INSERT INTO usuarios (correo, passwd) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bind_param("ss", $correo, $claveHash);
        
        if ($stmt->execute()) {
            return true; // Usuario creado exitosamente
        } else {
            return "Error al crear el usuario: " . $this->conn->error;
        }
    }

    
    public function obtenerTodos() {
        $query = "SELECT id, correo, creado_en FROM usuarios";
        $resultado = $this->conn->query($query);
        
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
}
?>
