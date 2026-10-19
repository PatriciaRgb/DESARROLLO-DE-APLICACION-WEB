USE arbol_de_higos;

ALTER TABLE usuarios
    ADD COLUMN rol VARCHAR(30) NOT NULL DEFAULT 'consulta',
    ADD CONSTRAINT chk_usuarios_rol CHECK (rol IN ('administrador', 'consulta'));

UPDATE usuarios SET rol = 'administrador' WHERE usuario = 'admin_prueba';