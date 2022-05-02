CREATE TABLE cursos(
	id int(255) NOT NULL AUTO_INCREMENT,
	nombre varchar(100) DEFAULT NULL,
	descripcion varchar(150) DEFAULT NULL,
    fecha_apertura datetime DEFAULT NULL,
    fecha_cierre datetime DEFAULT NULL,
	docente_id bigint(20) unsigned NOT NULL,
    link_clase text,
	created_at datetime DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	PRIMARY KEY (`id`),
	CONSTRAINT fk_cursos_users FOREIGN KEY (docente_id) REFERENCES users (id)
);

CREATE TABLE cursos_has_estudiantes(
	id int(255) NOT NULL AUTO_INCREMENT,
	curso_id int(255) NOT NULL,
	estudiante_id bigint(20) unsigned NOT NULL,
	created_at datetime DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	PRIMARY KEY (`id`),
	CONSTRAINT fk_cursos_has_estudiantes_users FOREIGN KEY (estudiante_id) REFERENCES users (id),
    CONSTRAINT fk_cursos_has_estudiantes_cursos FOREIGN KEY (curso_id) REFERENCES cursos (id)
);
