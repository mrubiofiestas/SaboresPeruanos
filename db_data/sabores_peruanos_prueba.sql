-- Crear y usar base de datos
CREATE DATABASE IF NOT EXISTS sabores_peruanos;
USE sabores_peruanos;

-- Tabla roles
CREATE TABLE roles (
  id_rol INT NOT NULL,
  tipo_rol VARCHAR(30) NOT NULL,
  PRIMARY KEY (id_rol)
);

INSERT INTO roles (id_rol, tipo_rol) VALUES
(1, 'Administrador'),
(2, 'Usuario'),
(3, 'Invitado');

-- Tabla usuario
CREATE TABLE usuario (
  email VARCHAR(50) NOT NULL,
  nombre VARCHAR(30) NOT NULL,
  apellidos VARCHAR(50) NOT NULL,
  direccion VARCHAR(100) DEFAULT NULL,
  clave VARCHAR(255) NOT NULL,
  id_rol INT DEFAULT 2,
  PRIMARY KEY (email),
  FOREIGN KEY (id_rol) REFERENCES roles (id_rol) ON DELETE SET NULL ON UPDATE CASCADE
);

INSERT INTO usuario (email, nombre, apellidos, direccion, clave, id_rol) VALUES
('admin@barperuano.com', 'Ana', 'Ramírez', 'Av. Perú 123', '$2y$10$eImiTXuWVxfM37uY4JANjQ==', 1),
('usuario1@bar.com', 'Carlos', 'Pérez', 'Jr. Cusco 456', '$2y$10$eImiTXuWVxfM37uY4JANjQ==', 2),
('invitado@bar.com', 'Luisa', 'Gómez', NULL, '$2y$10$eImiTXuWVxfM37uY4JANjQ==', 3);

CREATE TABLE platos (
  nombre_plato VARCHAR(50) NOT NULL,
  tipo VARCHAR(30) NOT NULL,
  precio DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (nombre_plato)
);

INSERT INTO platos (nombre_plato, tipo, precio) VALUES
('Ceviche Clásico', 'Entrada', 25.00),
('Lomo Saltado', 'Plato de Fondo', 28.50),
('Ají de Gallina', 'Plato de Fondo', 22.00),
('Anticuchos', 'Entrada', 18.00),
('Suspiro Limeño', 'Postre', 12.00);

CREATE TABLE ingredientes (
  nombre_ingrediente VARCHAR(50) NOT NULL,
  cantidad INT(11) NOT NULL,
  PRIMARY KEY (nombre_ingrediente)
);

INSERT INTO ingredientes (nombre_ingrediente, cantidad) VALUES
('Pescado', 50),
('Limón', 100),
('Cebolla', 80),
('Ají Amarillo', 70),
('Papa Amarilla', 100),
('Arroz', 200),
('Carne de Res', 60),
('Pollo', 50),
('Pan', 40),
('Leche Condensada', 30);

-- Tabla pedido
CREATE TABLE pedido (
  cod_pedido INT(11) NOT NULL AUTO_INCREMENT,
  descripcion TEXT DEFAULT NULL,
  email_usuario VARCHAR(50) DEFAULT NULL,
  PRIMARY KEY (cod_pedido),
  FOREIGN KEY (email_usuario) REFERENCES usuario (email) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO pedido (descripcion, email_usuario) VALUES
('Pedido con Ceviche y Anticuchos', 'usuario1@bar.com'),
('Solo Suspiro Limeño', 'usuario1@bar.com');

-- Tabla contiene
CREATE TABLE contiene (
  cod_pedido INT(11) NOT NULL,
  nombre_plato VARCHAR(50) NOT NULL,
  PRIMARY KEY (cod_pedido, nombre_plato),
  FOREIGN KEY (cod_pedido) REFERENCES pedido (cod_pedido) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (nombre_plato) REFERENCES platos (nombre_plato) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO contiene (cod_pedido, nombre_plato) VALUES
(1, 'Ceviche Clásico'),
(1, 'Anticuchos'),
(2, 'Suspiro Limeño');

-- Tabla gestiona
CREATE TABLE gestiona (
  email VARCHAR(50) NOT NULL,
  nombre_plato VARCHAR(50) NOT NULL,
  PRIMARY KEY (email, nombre_plato),
  FOREIGN KEY (email) REFERENCES usuario (email) ON UPDATE CASCADE,
  FOREIGN KEY (nombre_plato) REFERENCES platos (nombre_plato) ON UPDATE CASCADE
);

INSERT INTO gestiona (email, nombre_plato) VALUES
('admin@barperuano.com', 'Ceviche Clásico'),
('admin@barperuano.com', 'Ají de Gallina');

-- Tabla llevan
CREATE TABLE llevan (
  nombre_plato VARCHAR(50) NOT NULL,
  nombre_ingrediente VARCHAR(50) NOT NULL,
  PRIMARY KEY (nombre_plato, nombre_ingrediente),
  FOREIGN KEY (nombre_plato) REFERENCES platos (nombre_plato) ON UPDATE CASCADE,
  FOREIGN KEY (nombre_ingrediente) REFERENCES ingredientes (nombre_ingrediente) ON UPDATE CASCADE
);

INSERT INTO llevan (nombre_plato, nombre_ingrediente) VALUES
('Ceviche Clásico', 'Pescado'),
('Ceviche Clásico', 'Limón'),
('Ceviche Clásico', 'Cebolla'),
('Lomo Saltado', 'Carne de Res'),
('Lomo Saltado', 'Papa Amarilla'),
('Lomo Saltado', 'Arroz'),
('Ají de Gallina', 'Pollo'),
('Ají de Gallina', 'Ají Amarillo'),
('Ají de Gallina', 'Pan'),
('Suspiro Limeño', 'Leche Condensada');
