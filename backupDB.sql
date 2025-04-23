CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    correo VARCHAR(100) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    tipo ENUM('candidato', 'empresa') NOT NULL,
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE candidatos (
    id INT PRIMARY KEY,
    nombre VARCHAR(100),
    apellido VARCHAR(100),
    telefono VARCHAR(20),
    direccion VARCHAR(255),
    ciudad VARCHAR(100),
    formacion TEXT,
    experiencia TEXT,
    habilidades TEXT,
    idiomas TEXT,
    objetivo TEXT,
    logros TEXT,
    disponibilidad VARCHAR(50),
    redes TEXT,
    referencias TEXT,
    foto VARCHAR(255),      -- Ruta de la imagen
    cv_pdf VARCHAR(255),    -- Ruta del PDF
    FOREIGN KEY (id) REFERENCES usuarios(id) ON DELETE CASCADE
);
CREATE TABLE empresas (
    id INT PRIMARY KEY,
    nombre_empresa VARCHAR(150),
    direccion VARCHAR(255),
    telefono VARCHAR(20),
    descripcion TEXT,
    logo VARCHAR(255),
    FOREIGN KEY (id) REFERENCES usuarios(id) ON DELETE CASCADE
);
CREATE TABLE ofertas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    empresa_id INT,
    titulo VARCHAR(150),
    descripcion TEXT,
    requisitos TEXT,
    fecha_publicacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (empresa_id) REFERENCES empresas(id) ON DELETE CASCADE
);
CREATE TABLE aplicaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    oferta_id INT,
    candidato_id INT,
    fecha_aplicacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (oferta_id) REFERENCES ofertas(id) ON DELETE CASCADE,
    FOREIGN KEY (candidato_id) REFERENCES candidatos(id) ON DELETE CASCADE
);
