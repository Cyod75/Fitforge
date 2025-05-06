DROP DATABASE IF EXISTS fitforge;
CREATE DATABASE fitforge CHARACTER SET utf8mb4;
USE fitforge;

-- Roles de usuario
CREATE TABLE roles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) UNIQUE,
  descripcion VARCHAR(255)
);

-- Usuarios
CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) UNIQUE,
  correo VARCHAR(100) UNIQUE,
  clave VARCHAR(255),
  rol_id INT,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (rol_id) REFERENCES roles(id)
);

-- Categorías de ejercicios
CREATE TABLE categorias_ejercicios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) UNIQUE,
  descripcion TEXT
);

-- Ejercicios
CREATE TABLE ejercicios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  categoria_id INT,
  nombre VARCHAR(100),
  descripcion TEXT,
  FOREIGN KEY (categoria_id) REFERENCES categorias_ejercicios(id)
);

-- Rutinas de los usuarios
CREATE TABLE rutinas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT,
  nombre VARCHAR(100),
  descripcion TEXT,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Ejercicios dentro de las rutinas
CREATE TABLE ejercicios_rutina (
  id INT AUTO_INCREMENT PRIMARY KEY,
  rutina_id INT,
  ejercicio_id INT,
  dia_semana VARCHAR(10),
  series INT,
  repeticiones VARCHAR(50),
  FOREIGN KEY (rutina_id) REFERENCES rutinas(id),
  FOREIGN KEY (ejercicio_id) REFERENCES ejercicios(id)
);

-- Categorías de alimentos
CREATE TABLE categorias_alimentos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) UNIQUE,
  descripcion TEXT
);

-- Alimentos
CREATE TABLE alimentos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  categoria_id INT,
  nombre VARCHAR(100),
  calorias INT,
  proteina DECIMAL(5,2),
  carbohidratos DECIMAL(5,2),
  grasas DECIMAL(5,2),
  FOREIGN KEY (categoria_id) REFERENCES categorias_alimentos(id)
);

-- Favoritos de alimentos
CREATE TABLE favoritos_alimentos (
  usuario_id INT,
  alimento_id INT,
  agregado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (usuario_id, alimento_id),
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
  FOREIGN KEY (alimento_id) REFERENCES alimentos(id)
);


-- Insertar datos de ejemplo

-- Roles
INSERT INTO roles (nombre, descripcion) VALUES
('Admin', 'Acceso total a la aplicación'),
('Usuario', 'Acceso limitado a su información');

-- Usuarios
INSERT INTO usuarios (nombre, correo, clave, rol_id) VALUES
('admin', 'admin@gymapp.com', 'admin', 1),
('jordi', 'jordi@gymapp.com', '1234', 2);

-- Categorías de ejercicios
INSERT INTO categorias_ejercicios (nombre, descripcion) VALUES
('Calistenia', 'Ejercicios de peso corporal'),
('Gimnasio', 'Entrenamiento con pesas y máquinas'),
('Crossfit', 'Entrenamientos funcionales de alta intensidad');

-- Ejercicios
INSERT INTO ejercicios (categoria_id, nombre, descripcion) VALUES
(1, 'Flexiones', 'Flexiones de brazos en el suelo'),
(1, 'Dominadas', 'Elevaciones de cuerpo en barra fija'),
(2, 'Press de banca', 'Press de banca con barra para pectorales'),
(2, 'Sentadillas', 'Ejercicio de piernas con peso libre'),
(3, 'Burpees', 'Ejercicio de cuerpo completo de alta intensidad');

-- Categorías de alimentos
INSERT INTO categorias_alimentos (nombre, descripcion) VALUES
('Bajo en calorías', 'Alimentos ligeros en calorías'),
('Medio en calorías', 'Alimentos de balance medio'),
('Alto en calorías', 'Alimentos energéticos y calóricos');

-- Alimentos
INSERT INTO alimentos (categoria_id, nombre, calorias, proteina, carbohidratos, grasas) VALUES
(1, 'Manzana', 52, 0.26, 14.0, 0.17),
(2, 'Pan integral', 250, 12.0, 41.0, 4.5),
(3, 'Almendras', 579, 21.0, 22.0, 50.0);
