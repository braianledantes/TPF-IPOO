CREATE DATABASE ingresante;
USE ingresante;

CREATE TABLE actividad (
    id BIGINT AUTO_INCREMENT,
    descripcion_corta VARCHAR(100),
    descripcion_larga VARCHAR(500),
    PRIMARY KEY (id)
);
CREATE TABLE modulo (
    id BIGINT AUTO_INCREMENT,
    descripcion VARCHAR(150),
    tope_inscripciones INT DEFAULT 20,
    costo FLOAT,
    horario_inicio VARCHAR(5),
    horario_cierre VARCHAR(5),
    id_actividad BIGINT,
    PRIMARY KEY (id),
    FOREIGN KEY (id_actividad) REFERENCES actividad(id) ON UPDATE CASCADE ON DELETE CASCADE
);
CREATE TABLE modulo_en_linea (
    id BIGINT,
    link VARCHAR(200),
    bonificacion FLOAT DEFAULT 20,
    PRIMARY KEY (id),
    FOREIGN KEY (id) REFERENCES modulo(id) ON UPDATE CASCADE ON DELETE CASCADE
);
CREATE TABLE ingresante (
    legajo VARCHAR(15),
    dni VARCHAR(15) UNIQUE,
    nombre VARCHAR(50),
    apellido VARCHAR(50),
    correo_electronico VARCHAR(150),
    PRIMARY KEY (legajo)
);
CREATE TABLE inscripcion (
    id BIGINT AUTO_INCREMENT,
    legajo VARCHAR(15) NOT NULL,
    fecha DATE,
    costo_final FLOAT,
    PRIMARY KEY (id),
    FOREIGN KEY (legajo) REFERENCES ingresante(legajo) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE modulo_ingresante (
    id_modulo BIGINT,
    id_inscripcion BIGINT,
    PRIMARY KEY (id_modulo, id_inscripcion),
    FOREIGN KEY (id_modulo) REFERENCES modulo(id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (id_inscripcion) REFERENCES inscripcion(id) ON UPDATE CASCADE ON DELETE CASCADE
);