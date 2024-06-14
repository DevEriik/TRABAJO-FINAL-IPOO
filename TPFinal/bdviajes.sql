-- SQLBook: Code
CREATE DATABASE bdviajes;
----------- Creo que ya estan bien ---------------
CREATE TABLE empresa (
    idempresa bigint AUTO_INCREMENT,
    enombre varchar(150),
    edireccion varchar(150),
    PRIMARY KEY (idempresa)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 AUTO_INCREMENT = 1;

CREATE TABLE persona (
    idpersona bigint AUTO_INCREMENT, //!AGREGAMOS ESTE idpersona Con dudas
    nrodocumento varchar(15),
    nombre varchar(150),
    apellido varchar(150),
    telefono int, //!CAMBIAMOS A BIGINT porque nos tiraba un numero random
    PRIMARY KEY (nrodocumento)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 AUTO_INCREMENT = 1;

CREATE TABLE responsable (
    numeroEmpleado bigint AUTO_INCREMENT,
    numerolicencia bigint,
    nrodocumento varchar(15),
    PRIMARY KEY (numeroEmpleado),
    FOREIGN KEY (idpersona) REFERENCES persona (idpersona)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 AUTO_INCREMENT = 1;

CREATE TABLE viaje (
    idviaje bigint AUTO_INCREMENT,
    vdestino varchar(150),
    vcantmaxpasajeros int,
    idempresa bigint,
    numeroEmpleado bigint,
    vimporte float,
    PRIMARY KEY (idviaje),
    FOREIGN KEY (idempresa) REFERENCES empresa (idempresa),
    FOREIGN KEY (numeroEmpleado) REFERENCES responsable (numeroEmpleado) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8 AUTO_INCREMENT = 1;

CREATE TABLE pasajero (
    idpasajero int AUTO_INCREMENT,
    nrodocumento varchar(15),
    idviaje bigint,
    PRIMARY KEY (idpasajero),
    FOREIGN KEY (idpersona) REFERENCES persona (idpersona),
    FOREIGN KEY (idviaje) REFERENCES viaje (idviaje)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;