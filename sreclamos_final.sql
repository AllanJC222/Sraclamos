-- --------------------------------------------------------------------------
-- BASE DE DATOS: sreclamos
-- Versión revisada y corregida 
-- --------------------------------------------------------------------------

CREATE DATABASE IF NOT EXISTS sreclamos;
USE sreclamos;

-- =====================
-- Tabla: rol
-- =====================
CREATE TABLE IF NOT EXISTS rol (
  IdRol INT NOT NULL AUTO_INCREMENT,
  NombreRol VARCHAR(50) NOT NULL,
  Estado TINYINT NOT NULL DEFAULT '1' COMMENT '0=Inactivo, 1=Activo',
  PRIMARY KEY (IdRol)
);

-- =====================
-- Tabla: sector
-- =====================
CREATE TABLE IF NOT EXISTS sector (
  IdSector INT NOT NULL AUTO_INCREMENT,
  NombreSector VARCHAR(50) DEFAULT NULL,
  PRIMARY KEY (IdSector)
);

-- =====================
-- Tabla: barrio
-- =====================
CREATE TABLE IF NOT EXISTS barrio (
  IdBarrio INT NOT NULL AUTO_INCREMENT,
  NombreBarrio VARCHAR(100) NOT NULL,
  IdSector INT NOT NULL,
  PRIMARY KEY (IdBarrio),
  CONSTRAINT fk_barrio_sector
    FOREIGN KEY (IdSector) REFERENCES sector(IdSector)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

-- =====================
-- Tabla: usuario
-- =====================
CREATE TABLE IF NOT EXISTS usuario (
  IdUsuario INT NOT NULL AUTO_INCREMENT,
  NombreUsuario VARCHAR(50) NOT NULL,
  ApellidoUsuario VARCHAR(50) NOT NULL,
  Email VARCHAR(100) NOT NULL UNIQUE,
  Celular VARCHAR(15) NOT NULL,
  IdRol INT NOT NULL,
  Estado TINYINT NOT NULL DEFAULT '1' COMMENT '0=Inactivo, 1=Activo',
  FechaCreacion TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FechaActualizacion TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (IdUsuario),
  KEY RolUsuario_idx (IdRol),
  CONSTRAINT RolUsuarioFk FOREIGN KEY (IdRol) REFERENCES rol (IdRol)
);

-- =====================
-- Tabla: abonados
-- =====================
CREATE TABLE IF NOT EXISTS abonados (
  IdAbonado INT NOT NULL AUTO_INCREMENT,
  ClaveCatastral VARCHAR(20) NOT NULL,
  NoIdentidad VARCHAR(20) NOT NULL UNIQUE,
  CodigoAbonado VARCHAR(20) NOT NULL UNIQUE,
  NombreAbonado VARCHAR(45) NOT NULL,
  UsoDeSuelo VARCHAR(45) NOT NULL,
  TipoActividad VARCHAR(45) NOT NULL,
  IdSector INT NOT NULL,
  Direccion VARCHAR(150) NOT NULL,
  Celular VARCHAR(15) NOT NULL,
  Estado TINYINT NOT NULL DEFAULT '1' COMMENT '0=Inactivo, 1=Activo',
  FechaCreacion TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FechaActualizacion TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (IdAbonado),
  KEY ZonaAbonado_idx (IdSector),
  CONSTRAINT ZonaAbonadoFk FOREIGN KEY (IdSector) REFERENCES sector (IdSector)
);

-- =====================
-- Tabla: categoriareclamo
-- =====================
CREATE TABLE IF NOT EXISTS categoriareclamo (
  IdCategoria INT NOT NULL AUTO_INCREMENT,
  Nombre VARCHAR(50) NOT NULL,
  PRIMARY KEY (IdCategoria)
);


-- =====================
-- Tabla: reclamos 
-- =====================
CREATE TABLE IF NOT EXISTS reclamos (
  IdReclamo INT NOT NULL AUTO_INCREMENT,
  Descripcion VARCHAR(255) NOT NULL,
  IdCategoria INT NOT NULL,
  FechaInicial TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FechaFinal TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  IdAbonado INT NOT NULL,
  CodigoSeguimiento VARCHAR(50) NULL,
  IdSector INT NOT NULL,
  IdBarrio INT NOT NULL, 
  Estado TINYINT NOT NULL DEFAULT '1' COMMENT '0=Inactivo, 1=Activo',
  CoordenadasUbicacion VARCHAR(255) NULL,
  ImagenEvidencia LONGBLOB NULL,
  IdUsuarioOperador INT NOT NULL, 
  Comentario VARCHAR(500) NULL,
  EstadoReclamo ENUM('Pendiente','En Proceso','Resuelto') DEFAULT 'Pendiente',
  PRIMARY KEY (IdReclamo),
  FOREIGN KEY (IdCategoria) REFERENCES categoriareclamo (IdCategoria),
  FOREIGN KEY (IdAbonado) REFERENCES abonados (IdAbonado),
  FOREIGN KEY (IdSector) REFERENCES sector (IdSector),
  FOREIGN KEY (IdBarrio) REFERENCES barrio (IdBarrio),
  CONSTRAINT ReclamoOperadorFk FOREIGN KEY (IdUsuarioOperador) REFERENCES usuario (IdUsuario)
);


-- =====================
-- Tabla: operadordistribucion (CAMPO RENOMBRADO)
-- =====================
CREATE TABLE IF NOT EXISTS operadordistribucion (
    IdOperadorDistribucion INT NOT NULL AUTO_INCREMENT,
    HoraInicio DATETIME NOT NULL,
    HoraFinal DATETIME NOT NULL,
    IdUsuarioOperador INT NOT NULL, 
    IdSector INT NOT NULL,
    Estado TINYINT NOT NULL DEFAULT '1' COMMENT '0=Inactivo, 1=Activo',
    FechaCreacion TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FechaActualizacion TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    PRIMARY KEY (IdOperadorDistribucion),
    -- Los índices y la clave foránea se actualizan para reflejar el nuevo nombre:
    KEY UsuarioOperador_idx (IdUsuarioOperador),
    KEY SectorAsignado_idx (IdSector),
    CONSTRAINT OperadorUsuarioFk FOREIGN KEY (IdUsuarioOperador) REFERENCES usuario (IdUsuario),
    
    CONSTRAINT SectorAsignadoFk FOREIGN KEY (IdSector) REFERENCES sector (IdSector)
);


-- =====================
-- Tabla: usuariolog
-- =====================
CREATE TABLE IF NOT EXISTS usuariolog (
  id INT NOT NULL AUTO_INCREMENT,
  user_name VARCHAR(50) NOT NULL,
  user_pass VARCHAR(256) NOT NULL,
  user_tipo VARCHAR(2) DEFAULT NULL,
  PRIMARY KEY (id)
);

INSERT INTO usuariolog (user_name, user_pass, user_tipo) VALUES
-- Usuario administrador
('admin', '$2y$12$bJaD1xYG5XX.tHChh23jEupQ0P1UfHOvOXGKdwlLyCT3J.Yy2mXJC', '1'),
('standard', '$2y$12$bJaD1xYG5XX.tHChh23jEupQ0P1UfHOvOXGKdwlLyCT3J.Yy2mXJC', '2'),

