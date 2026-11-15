-- Datos de demostración de "El Árbol de Higos".
-- Todo es ficticio: nombres, correos (example.com) y comentarios.
-- No incluye usuarios ni contraseñas: las cuentas se crean siguiendo el README.

USE arbol_de_higos;

INSERT INTO resenas (nombre, correo, libro, calificacion, comentario, fecha) VALUES
('Lucía Mendoza',   'lucia@example.com',   'The Bell Jar',          5, 'Una lectura intensa que se queda contigo mucho tiempo.',   CURDATE()),
('Mateo Ramírez',   'mateo@example.com',   'Ariel',                 4, 'Poemas de ritmo fuerte; me gustó la selección.',          CURDATE()),
('Valeria Soto',    'valeria@example.com', 'The Bell Jar',          5, 'Me sentí identificada en muchas partes de la historia.',  CURDATE()),
('Diego Hernández', 'diego@example.com',   'Cien años de soledad',  3, 'Interesante, aunque los nombres repetidos me confundieron.', CURDATE()),
('Camila Torres',   'camila@example.com',  'Ariel',                 4, 'Una edición muy cuidada y una buena introducción.',       CURDATE()),
('Pruebas HTML',    'html@example.com',    'Libro de prueba',       2, '<b>demo</b> este comentario muestra que el HTML se escapa', CURDATE());
