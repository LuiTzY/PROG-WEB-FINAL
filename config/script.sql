-- Base de datos
CREATE DATABASE IF NOT EXISTS plataforma_empleos;
USE plataforma_empleos;

-- Tabla: usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    correo VARCHAR(100) UNIQUE NOT NULL,
    contraseña VARCHAR(255) NOT NULL,
);

-- Tabla: empresas
CREATE TABLE empresas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    nombre_empresa VARCHAR(100),
    direccion VARCHAR(150),
    contacto VARCHAR(100),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
);
-- Tabla: candidatos
CREATE TABLE candidatos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    nombre VARCHAR(100),
    apellido VARCHAR(100),
    telefono VARCHAR(20),
    direccion VARCHAR(150),
    ciudad VARCHAR(100),
    resumen TEXT,
    disponibilidad VARCHAR(50),
    habilidades TEXT,
    idiomas TEXT,
    redes_profesionales TEXT,
    referencias TEXT,
    foto VARCHAR(255), -- Lo ideal es que guarde una ruta de donde se encuentran los archivos
    cv_pdf VARCHAR(255), -- Lo ideal es que guarde una ruta de donde se encuentran los archivos
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE -- Se borran los registros en cascada
);


-- Tabla: formación académica
CREATE TABLE formacion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_candidato INT NOT NULL,
    institucion VARCHAR(100),
    titulo VARCHAR(100),
    fecha_inicio DATE,
    fecha_fin DATE,
    FOREIGN KEY (id_candidato) REFERENCES candidatos(id) ON DELETE CASCADE
);

-- Tabla: experiencia laboral
CREATE TABLE experiencia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_candidato INT NOT NULL,
    empresa VARCHAR(100),
    puesto VARCHAR(100),
    fecha_inicio DATE,
    fecha_fin DATE,
    FOREIGN KEY (id_candidato) REFERENCES candidatos(id) ON DELETE CASCADE
);

-- Tabla: ofertas de empleo
CREATE TABLE ofertas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_empresa INT NOT NULL,
    titulo VARCHAR(100),
    descripcion TEXT,
    requisitos TEXT,
    fecha_creacion DATE DEFAULT CURRENT_DATE,
    FOREIGN KEY (id_empresa) REFERENCES empresas(id) ON DELETE CASCADE
);

-- Tabla: aplicaciones a ofertas
CREATE TABLE aplicaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_candidato INT NOT NULL,
    id_oferta INT NOT NULL,
    fecha_aplicacion DATE DEFAULT CURRENT_DATE,
    FOREIGN KEY (id_candidato) REFERENCES candidatos(id) ON DELETE CASCADE,
    FOREIGN KEY (id_oferta) REFERENCES ofertas(id) ON DELETE CASCADE,
    UNIQUE KEY unique_aplicacion (id_candidato, id_oferta)
);
