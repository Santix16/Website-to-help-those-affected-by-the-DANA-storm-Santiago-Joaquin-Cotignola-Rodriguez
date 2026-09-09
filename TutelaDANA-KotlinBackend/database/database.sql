-- Tutela DANA: esquema unico para instalaciones nuevas y bases existentes.
CREATE DATABASE IF NOT EXISTS tele_dana;
USE tele_dana;

CREATE TABLE IF NOT EXISTS usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('USER', 'ADMIN') NOT NULL DEFAULT 'USER',
    tonkens INT NOT NULL DEFAULT 0 CHECK (tonkens >= 0),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    descripcion VARCHAR(255) DEFAULT '',
    precio_tonkens INT NOT NULL CHECK (precio_tonkens >= 0),
    stock INT NOT NULL DEFAULT 0 CHECK (stock >= 0),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_producto_nombre (nombre)
);

CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    estado VARCHAR(50) NOT NULL DEFAULT 'pendiente',
    total_tonkens INT NOT NULL DEFAULT 0 CHECK (total_tonkens >= 0),
    fecha_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_usuario_id (usuario_id),
    CONSTRAINT fk_pedidos_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id_usuario)
        ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS pedidos_productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL CHECK (cantidad > 0),
    INDEX idx_pedido_id (pedido_id),
    INDEX idx_producto_id (producto_id),
    CONSTRAINT fk_pedidos_productos_pedido FOREIGN KEY (pedido_id) REFERENCES pedidos(id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_pedidos_productos_producto FOREIGN KEY (producto_id) REFERENCES productos(id)
        ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS contacto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    mensaje TEXT NOT NULL,
    fecha_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS mensajes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    remitente_id INT NOT NULL,
    destinatario_id INT NOT NULL,
    mensaje TEXT NOT NULL,
    fecha_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_remitente_id (remitente_id),
    INDEX idx_destinatario_id (destinatario_id),
    CONSTRAINT fk_mensajes_remitente FOREIGN KEY (remitente_id) REFERENCES usuarios(id_usuario)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_mensajes_destinatario FOREIGN KEY (destinatario_id) REFERENCES usuarios(id_usuario)
        ON UPDATE CASCADE ON DELETE RESTRICT
);

-- Compatibilidad para una tele_dana creada antes de añadir administracion y stock.
ALTER TABLE usuarios
    ADD COLUMN IF NOT EXISTS role ENUM('USER', 'ADMIN') NOT NULL DEFAULT 'USER';

ALTER TABLE productos
    ADD COLUMN IF NOT EXISTS stock INT NOT NULL DEFAULT 0;

INSERT INTO productos (nombre, descripcion, precio_tonkens, stock)
VALUES
    ('Kit de alimentos', 'Paquete basico de alimentos para familias afectadas', 50, 0),
    ('Kit de limpieza', 'Productos de limpieza e higiene personal', 40, 0),
    ('Ropa basica', 'Conjunto de ropa para uso diario', 30, 0),
    ('Material de apoyo', 'Articulos esenciales para la recuperacion', 35, 0)
ON DUPLICATE KEY UPDATE
    descripcion = VALUES(descripcion),
    precio_tonkens = VALUES(precio_tonkens);

-- Cuenta local inicial. Cambia la contrasena despues del primer acceso.
INSERT INTO usuarios (nombre, email, password, role, tonkens)
VALUES ('Administrador', 'admin@tuteladana.local', '$2y$10$qnGfKzF3n4tMlnqAH8c9Ge3Pnum21Tot/7zmG4.sgJ7Gjw3Y5H1BW', 'ADMIN', 0)
ON DUPLICATE KEY UPDATE role = 'ADMIN';
