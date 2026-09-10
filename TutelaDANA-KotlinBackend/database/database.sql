-- Tutela DANA: esquema unico para instalaciones nuevas y bases existentes.
CREATE DATABASE IF NOT EXISTS tele_dana;
USE tele_dana;

CREATE TABLE IF NOT EXISTS usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    telefono VARCHAR(20) DEFAULT NULL,
    role ENUM('USER', 'ADMIN') NOT NULL DEFAULT 'USER',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    descripcion VARCHAR(255) DEFAULT '',
    stock INT NOT NULL DEFAULT 0 CHECK (stock >= 0),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_producto_nombre (nombre)
);

CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    producto VARCHAR(150) NULL,
    producto_id INT NULL,
    estado VARCHAR(50) NOT NULL DEFAULT 'pendiente',
    fecha_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_usuario_id (usuario_id),
    INDEX idx_producto_id (producto_id),
    CONSTRAINT fk_pedidos_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id_usuario)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_pedidos_producto FOREIGN KEY (producto_id) REFERENCES productos(id)
        ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS donaciones (
    id_donacion INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT DEFAULT 1,
    direccion_recogida TEXT NOT NULL,
    telefono_contacto VARCHAR(20) NOT NULL,
    notas_adicionales TEXT NULL,
    estado VARCHAR(50) DEFAULT 'Pendiente de Recogida',
    fecha_donacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (producto_id) REFERENCES productos(id)
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
    mensaje_padre_id INT DEFAULT NULL, -- NULL si es el mensaje inicial; ID del mensaje raíz si es un hilo
    usuario_id INT DEFAULT NULL,        -- ID del usuario registrado (si existe)
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    mensaje TEXT NOT NULL,
    remitente ENUM('USER', 'ADMIN') NOT DEFAULT 'USER',
    leido TINYINT(1) DEFAULT 0,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (mensaje_padre_id) REFERENCES contacto(id) ON DELETE CASCADE
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

INSERT INTO productos (nombre, descripcion, stock)
VALUES
    -- Servicios de comida
    ('COMIDA PREPARADA (LISTO PARA CALENTAR)', 'Alimentos listos para consumo inmediato o calentamiento rápido', 50),
    ('LATAS DE CONSERVA (ATÚN, LEGUMBRES, SOPA)', 'Conservas variadas de larga duración', 100),
    ('PAN Y GALLETAS SECAS', 'Productos secos de panadería y galletas', 80),
    ('LECHE EN POLVO O UHT', 'Leche UHT y en polvo para consumo diario', 60),
    ('AGUA POTABLE EMBOTELLADA (1L O 5L)', 'Agua potable embotellada para consumo e higiene básica', 150),
    ('FRUTAS NO PERECEDERAS', 'Frutas no perecederas y frutos secos', 40),
    ('PAQUETES DE ARROZ Y PASTA', 'Arroz, pasta y legumbres secas', 100),

    -- Productos de limpieza
    ('JABÓN Y CHAMPÚ', 'Artículos para la higiene corporal diaria', 75),
    ('PAPEL HIGIÉNICO', 'Rollos de papel higiénico y pañuelos', 100),
    ('DETERGENTE Y LIMPIADORES', 'Detergente, lejía y limpiadores multisuperficie', 60),

    -- Ropa y calzado
    ('ROPA PARA MUJER', 'Prendas textiles variadas para mujer', 30),
    ('ROPA PARA HOMBRE', 'Prendas textiles variadas para hombre', 30),
    ('ROPA PARA NIÑOS', 'Prendas textiles infantiles de diversas tallas', 30),
    ('CALZADO Y MANTAS', 'Calzado de abrigo, mantas y ropa de cama', 40)
ON DUPLICATE KEY UPDATE
    descripcion = VALUES(descripcion);

-- Cuenta local inicial. Cambia la contrasena despues del primer acceso.
INSERT INTO usuarios (nombre, email, password, role)
VALUES ('Administrador', 'admin@tuteladana.local', '$2y$10$qnGfKzF3n4tMlnqAH8c9Ge3Pnum21Tot/7zmG4.sgJ7Gjw3Y5H1BW', 'ADMIN')
ON DUPLICATE KEY UPDATE role = 'ADMIN';
