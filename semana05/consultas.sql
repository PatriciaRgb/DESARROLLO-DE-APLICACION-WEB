-- Crear la base de datos
CREATE DATABASE arbol_de_higos;

-- Usar la base de datos
USE arbol_de_higos;

-- Crear la tabla principal
CREATE TABLE resenas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(150),
    libro VARCHAR(150) NOT NULL,
    calificacion INT,
    comentario TEXT
);

-- Insertar registros de prueba
INSERT INTO resenas (nombre, correo, libro, calificacion, comentario)
VALUES ('Patricia', 'patricia@test.com', 'The Bell Jar', 5, 'Un libro que te marca para siempre.');

INSERT INTO resenas (nombre, correo, libro, calificacion, comentario)
VALUES ('Ana', 'ana@test.com', 'Ariel', 4, 'Poesía intensa y hermosa.');

INSERT INTO resenas (nombre, correo, libro, calificacion, comentario)
VALUES ('Sofia', 'sofia@test.com', 'The Bell Jar', 5, 'Me sentí identificada en muchas partes.');

-- Consultar todos los registros
SELECT * FROM resenas;