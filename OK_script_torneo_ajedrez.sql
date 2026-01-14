CREATE DATABASE IF NOT EXISTS torneo_ajedrez DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE torneo_ajedrez ;

CREATE TABLE profesores (
    idProfesor smallint unsigned AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE -- Nombre del profesor. En esta tabla se incluyen tutores y no tutores
);

CREATE TABLE inscripciones (
    idInscripcion smallint unsigned AUTO_INCREMENT PRIMARY KEY,
    clase CHAR(6) NOT NULL UNIQUE,  -- Ejemplo: 2DAW, 1ESOA
    idTutor smallint unsigned NOT NULL,
    observaciones VARCHAR(200) NULL,
	participa_organizacion bit NOT NULL,
    FOREIGN KEY (idTutor) REFERENCES profesores(idProfesor)
	ON DELETE CASCADE
);

CREATE TABLE inscripciones_alumnos (
	idInscripcion_alumno int unsigned AUTO_INCREMENT PRIMARY KEY,
	idInscripcion smallint unsigned NOT NULL,
	nombre VARCHAR(100) NOT NULL, -- Nombre del alumno
	FOREIGN KEY (idInscripcion) REFERENCES inscripciones(idInscripcion)
	ON DELETE CASCADE
);

INSERT INTO profesores (nombre) VALUES 
('Magdalena Sánchez'),
('Rosalía Carrasco'),
('Alberto Domínguez'),
('Tomás Mogío'),
('Isabel Muñoz');
