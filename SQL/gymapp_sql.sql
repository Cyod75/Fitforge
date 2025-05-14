DROP DATABASE IF EXISTS fitforge;
CREATE DATABASE fitforge CHARACTER SET utf8mb4;
USE fitforge;

-- Usuarios (incluye el rol como texto)
CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) UNIQUE,
  correo VARCHAR(100) UNIQUE,
  clave VARCHAR(255),
  rol ENUM('Admin', 'Usuario') DEFAULT 'Usuario',
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Ejercicios (categoría como texto)
CREATE TABLE ejercicios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100),
  descripcion TEXT
);

-- Ejercicios dentro de las rutinas
CREATE TABLE rutinas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT,
  ejercicio_id INT,
  dia_semana VARCHAR(10),
  intensidad ENUM('3x12','3x8','4x10','4x12','5x5'),
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
  FOREIGN KEY (ejercicio_id) REFERENCES ejercicios(id)
);

-- Alimentos (categoría como texto)
CREATE TABLE alimentos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  categoria ENUM('Bajo en calorías', 'Medio en calorías', 'Alto en calorías'),
  nombre VARCHAR(100),
  calorias INT,
  proteina DECIMAL(5,2),
  carbohidratos DECIMAL(5,2),
  grasas DECIMAL(5,2)
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

CREATE TABLE progreso_fisico (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT,
  fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  peso DECIMAL(5,2),
  altura DECIMAL(4,2),
  biceps DECIMAL(5,2),
  pecho DECIMAL(5,2),
  cintura DECIMAL(5,2),
  pierna DECIMAL(5,2),
  imc DECIMAL(5,2),
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);


-- Insertar datos
INSERT INTO usuarios (nombre, correo, clave, rol) VALUES
('admin', 'admin@gymapp.com', '$2y$10$jzGQA/udLnQzaI.npeSCo.4fLgc9VxjEeXrPO0rtMyZvVF1aAnpla', 'Admin');

INSERT INTO ejercicios (nombre, descripcion) VALUES
('Flexiones', 'Flexiones de brazos en el suelo'),
('Dominadas', 'Elevaciones de cuerpo en barra fija'),
('Press de banca', 'Press de banca con barra para pectorales'),
('Sentadillas', 'Ejercicio de piernas con peso libre'),
('Burpees', 'Ejercicio de cuerpo completo de alta intensidad'),
('Plancha', 'Ejercicio isométrico para fortalecer core'),
('Curl de bíceps', 'Flexión de brazos con mancuerna o barra'),
('Press militar', 'Press vertical con barra o mancuernas para hombros'),
('Remo con barra', 'Tirón de barra hacia el pecho para espalda'),
('Peso muerto', 'Levantamiento de barra desde el suelo para cadena posterior'),
('Zancadas', 'Paso largo alterno para trabajar cuádriceps y glúteos'),
('Elevaciones laterales', 'Levantamiento de mancuernas lateral para hombros'),
('Fondos en paralelas', 'Flexiones de brazos en barras paralelas'),
('Abdominales crunch', 'Contracción de abdominales en posición supina'),
('Russian twist', 'Giro de tronco sentado para oblicuos'),
('Mountain climbers', 'Plancha con rodillas al pecho de forma alterna'),
('Saltos de caja', 'Pliométrico salto sobre plataforma elevada'),
('Jalones al pecho', 'Tirón de polea alta hacia el pecho'),
('Press de tríceps', 'Extensión de brazos en polea alta para tríceps'),
('Hip thrust', 'Elevación de cadera con barra para glúteos'),
('Plank to pushup', 'Transición de plancha baja a alta para core y brazos'),
('Skipping', 'Elevación rápida de rodillas en el sitio para cardio'),
('Russian push-ups', 'Flexiones con rotación de tronco para pectorales y core'),
('Peso turco', 'Levantamiento y bloqueo de kettlebell sobre cabeza'),
('Swing de kettlebell', 'Balanceo de pesa rusa entre piernas y a la altura del pecho'),
('Sentadilla búlgara', 'Sentadilla unilateral con pie trasero elevado'),
('Pull-over con mancuerna', 'Extensión de brazos por encima de la cabeza recostado'),
('Step-up', 'Subida a banco alternando piernas para cuádriceps y glúteos'),
('L-sit', 'Isométrico en paralelas con piernas extendidas en L');


INSERT INTO alimentos (categoria, nombre, calorias, proteina, carbohidratos, grasas) VALUES
('Bajo en calorías', 'Manzana', 52, 0.26, 14.0, 0.17),
('Medio en calorías', 'Pan integral', 250, 12.0, 41.0, 4.5),
('Alto en calorías', 'Almendras', 579, 21.0, 22.0, 50.0);

use fitforge;
SELECT * FROM usuarios;	