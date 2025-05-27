CREATE DATABASE IF NOT EXISTS sabores_peruanos;
USE sabores_peruanos;

CREATE TABLE roles (
  id_rol INT NOT NULL,
  tipo_rol VARCHAR(30) NOT NULL,
  PRIMARY KEY (id_rol)
);

INSERT INTO `roles` (`id_rol`, `tipo_rol`) VALUES
(1, 'Administrador'),
(2, 'Usuario');
(3, 'Invitado');

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

CREATE TABLE platos (
  nombre_plato VARCHAR(50) NOT NULL,
  tipo VARCHAR(30) NOT NULL,
  precio DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (nombre_plato)
);

CREATE TABLE ingredientes (
  nombre_ingrediente VARCHAR(50) NOT NULL,
  cantidad INT(11) NOT NULL,
  PRIMARY KEY (nombre_ingrediente)
);

INSERT INTO ingredientes (nombre_ingrediente, cantidad) VALUES
('Carne', 100),
('Patatas', 100),
('Mariscos', 100),
('Pato', 50),
('Arroz', 100),
('Papa amarilla', 80),
('Pollo', 100),
('Pescado', 150),
('Limón', 150),
('Leche', 100),
('Calamar', 60),
('Cebolla', 100),
('Tomate', 100),
('Patata', 100),
('Crema', 80),
('Ají amarillo', 50),
('Ensalada', 50),
('Rocoto', 30),
('Tallarines', 70),
('Queso', 20);


CREATE TABLE pedido (
  cod_pedido INT(11) NOT NULL AUTO_INCREMENT,
  descripcion TEXT DEFAULT NULL,
  email_usuario VARCHAR(50) DEFAULT NULL,
  PRIMARY KEY (cod_pedido),
  FOREIGN KEY (email_usuario) REFERENCES usuario (email) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE contiene (
  cod_pedido INT(11) NOT NULL,
  nombre_plato VARCHAR(50) NOT NULL,
  PRIMARY KEY (cod_pedido, nombre_plato),
  FOREIGN KEY (cod_pedido) REFERENCES pedido (cod_pedido) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (nombre_plato) REFERENCES platos (nombre_plato) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE gestiona (
  email VARCHAR(50) NOT NULL,
  nombre_plato VARCHAR(50) NOT NULL,
  PRIMARY KEY (email, nombre_plato),
  FOREIGN KEY (email) REFERENCES usuario (email) ON UPDATE CASCADE,
  FOREIGN KEY (nombre_plato) REFERENCES platos (nombre_plato) ON UPDATE CASCADE
);

CREATE TABLE llevan (
  nombre_plato VARCHAR(50) NOT NULL,
  nombre_ingrediente VARCHAR(50) NOT NULL,
  PRIMARY KEY (nombre_plato, nombre_ingrediente),
  FOREIGN KEY (nombre_plato) REFERENCES platos (nombre_plato) ON UPDATE CASCADE,
  FOREIGN KEY (nombre_ingrediente) REFERENCES ingredientes (nombre_ingrediente) ON UPDATE CASCADE
);

INSERT INTO llevan (nombre_plato, nombre_ingrediente) VALUES
('Anticuchos', 'Carne'),
('Arroz con Mariscos', 'Mariscos'),
('Arroz con Pato', 'Pato'),
('Cabrito a la Norteña', 'Carne'),
('Causa de Pollo', 'Papa amarilla'),
('Causa de Pollo', 'Pollo'),
('Ceviche', 'Pescado'),
('Ceviche', 'Limón'),
('Chicharrón de Calamar', 'Calamar'),
('Jalea Mixta', 'Mariscos'),
('Leche de Tigre', 'Pescado'),
('Leche de Tigre', 'Limón'),
('Leche de Tigre', 'Leche'),
('Lomo Saltado', 'Carne'),
('Lomo Saltado', 'Arroz'),
('Lomo Saltado', 'Cebolla'),
('Ocopa', 'Patata'),
('Ocopa', 'Crema'),
('Papa a la Huancaína', 'Patata'),
('Papa a la Huancaína', 'Ají amarillo'),
('Pollo a la Brasa con Papas', 'Pollo'),
('Pollo a la Brasa con Papas', 'Patatas'),
('Pollo a la Brasa con Papas', 'Ensalada'),
('Rocoto Relleno', 'Rocoto'),
('Rocoto Relleno', 'Crema'),
('Tallarines a la Huancaína', 'Tallarines'),
('Tallarines a la Huancaína', 'Carne'),
('Tallarines a la Huancaína', 'Cebolla'),
('Tallarines a la Huancaína', 'Tomate'),
('Tequeños', 'Queso');



INSERT INTO `platos` (`nombre_plato`, `tipo`, `precio`) VALUES
('Anticuchos', 'Parrilla', 12.00),
('Arroz con Mariscos', 'Mariscos', 20.00),
('Arroz con Pato', 'Ave', 15.00),
('Cabrito a la Norteña', 'Carne', 20.00),
('Causa de Pollo', 'Entrada', 5.00),
('Ceviche', 'Mariscos', 12.00),
('Chicharrón de Calamar', 'Mariscos', 6.00),
('Jalea Mixta', 'Mariscos', 18.00),
('Leche de Tigre', 'Mariscos', 10.50),
('Lomo Saltado', 'Carne', 11.00),
('Ocopa', 'Entrada', 3.50),
('Papa a la Huancaína', 'Entrada', 3.00),
('Pollo a la Brasa con Papas', 'Ave', 25.00),
('Rocoto Relleno', 'Entrada', 3.00),
('Tallarines a la Huancaína', 'Pasta', 8.00),
('Tequeños', 'Entrada', 5.00);


INSERT INTO `usuario` (`email`, `nombre`, `apellidos`, `direccion`, `clave`, `id_rol`) VALUES
('mrubiofiestas@gmail.com', 'Milagros', 'Rubio', 'calle mar y sierra', 'morita01', 2);

