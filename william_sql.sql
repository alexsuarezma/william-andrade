CREATE TABLE cursos(
	id int(255) NOT NULL AUTO_INCREMENT,
	nombre varchar(100) DEFAULT NULL,
	descripcion varchar(150) DEFAULT NULL,
    jornada varchar(100) DEFAULT NULL,
    nivel varchar(100) DEFAULT NULL,
    grupo varchar(100) DEFAULT NULL,
    periodo varchar(100) DEFAULT NULL,
    estado tinyint(1) DEFAULT 1,
	created_at datetime DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE materias(
	id int(255) NOT NULL AUTO_INCREMENT,
	curso_id int(255) NOT NULL,
	nombre varchar(100) DEFAULT NULL,
	descripcion varchar(150) DEFAULT NULL,
    fecha_apertura datetime DEFAULT NULL,
    fecha_cierre datetime DEFAULT NULL,
	docente_id bigint(20) unsigned NOT NULL,
    estado tinyint(1) DEFAULT 1,
    link_clase text,
    malla_id int(255),
	created_at datetime DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	PRIMARY KEY (`id`),
    CONSTRAINT fk_materias_cursos FOREIGN KEY (curso_id) REFERENCES cursos (id),
	CONSTRAINT fk_materias_users FOREIGN KEY (docente_id) REFERENCES users (id)
);

CREATE TABLE cursos_has_materias(
	id int(255) NOT NULL AUTO_INCREMENT,
	materia_id int(255) NOT NULL,
	curso_id bigint(20) unsigned NOT NULL,
	created_at datetime DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	PRIMARY KEY (`id`),
	CONSTRAINT fk_cursos_has_materias_cursos FOREIGN KEY (curso_id) REFERENCES cursos (id),
    CONSTRAINT fk_cursos_has_materias_materias FOREIGN KEY (materia_id) REFERENCES materias (id)
);

CREATE TABLE materias_has_estudiantes(
	id int(255) NOT NULL AUTO_INCREMENT,
	materia_id int(255) NOT NULL,
	estudiante_id bigint(20) unsigned NOT NULL,
	created_at datetime DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	PRIMARY KEY (`id`),
	CONSTRAINT fk_materias_has_estudiantes_users FOREIGN KEY (estudiante_id) REFERENCES users (id),
    CONSTRAINT fk_materias_has_estudiantes_materias FOREIGN KEY (materia_id) REFERENCES materias (id)
);
