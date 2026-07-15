-- ---------------------------------------------------------
-- Tablas del modelo BD_SeguimientoAcademico_FIS
-- DDL adaptado del EER de MySQL Workbench
-- ---------------------------------------------------------

-- ---------------------------------------------------------
-- Table `malla`
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS `malla` (
  `id_malla` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(30) NOT NULL,
  `anio_inicio` YEAR NOT NULL,
  `anio_fin` YEAR NULL,
  `vigente` BOOLEAN NOT NULL DEFAULT TRUE,
  `resolucion` VARCHAR(80) NULL,
  `programa_pdf` VARCHAR(255) NULL COMMENT 'ruta o nombre del archivo',
  `total_creditos` DECIMAL(5,2) NULL,
  `descripcion` VARCHAR(150) NULL,
  PRIMARY KEY (`id_malla`),
  UNIQUE INDEX `nombre_UNIQUE` (`nombre` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- ---------------------------------------------------------
-- Table `curso`
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS `curso` (
  `cod_curso` VARCHAR(15) NOT NULL,
  `nombre` VARCHAR(120) NOT NULL,
  `ciclo` TINYINT NOT NULL,
  `creditos` DECIMAL(3,1) NOT NULL,
  `horas_teoria` TINYINT NOT NULL DEFAULT 0,
  `horas_practica` TINYINT NOT NULL DEFAULT 0,
  `tipo` ENUM('Obligatorio', 'Electivo') NOT NULL,
  `id_malla` INT NOT NULL,
  PRIMARY KEY (`cod_curso`),
  INDEX `fk_Curso_Malla1_idx` (`id_malla` ASC) VISIBLE,
  CONSTRAINT `fk_Curso_Malla1`
    FOREIGN KEY (`id_malla`)
    REFERENCES `malla` (`id_malla`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- ---------------------------------------------------------
-- Table `prerrequisito`
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS `prerrequisito` (
  `id_prerrequisito` INT NOT NULL AUTO_INCREMENT,
  `cod_curso` VARCHAR(15) NOT NULL,
  `cod_prerrequisito` VARCHAR(15) NOT NULL,
  PRIMARY KEY (`id_prerrequisito`),
  UNIQUE INDEX `uq_curso_prerreq` (`cod_curso` ASC, `cod_prerrequisito` ASC) VISIBLE,
  INDEX `fk_Prerrequisito_Curso1_idx` (`cod_curso` ASC) VISIBLE,
  INDEX `fk_Prerrequisito_Curso2_idx` (`cod_prerrequisito` ASC) VISIBLE,
  CONSTRAINT `fk_Prerrequisito_Curso1`
    FOREIGN KEY (`cod_curso`)
    REFERENCES `curso` (`cod_curso`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `fk_Prerrequisito_Curso2`
    FOREIGN KEY (`cod_prerrequisito`)
    REFERENCES `curso` (`cod_curso`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `chk_prerreq_no_autoref` CHECK (`cod_curso` <> `cod_prerrequisito`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- ---------------------------------------------------------
-- Table `estudiante`
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS `estudiante` (
  `cod_estudiante` VARCHAR(11) NOT NULL,
  `dni` CHAR(8) NOT NULL,
  `nombres` VARCHAR(80) NOT NULL,
  `apellidos` VARCHAR(80) NOT NULL,
  `correo` VARCHAR(120) NULL,
  `telefono` VARCHAR(20) NULL,
  `sexo` ENUM('M', 'F', 'O') NULL,
  `ciclo_actual` TINYINT NULL,
  `id_malla` INT NULL COMMENT 'se asigna automaticamente por trigger segun el codigo; NULL solo si el anio de ingreso no esta cubierto por ninguna malla registrada',
  `fecha_registro` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cod_estudiante`),
  UNIQUE INDEX `dni_UNIQUE` (`dni` ASC) VISIBLE,
  INDEX `fk_Estudiante_Malla1_idx` (`id_malla` ASC) VISIBLE,
  CONSTRAINT `fk_Estudiante_Malla1`
    FOREIGN KEY (`id_malla`)
    REFERENCES `malla` (`id_malla`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- ---------------------------------------------------------
-- Table `estado_academico`
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS `estado_academico` (
  `id_estado` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(40) NOT NULL,
  `descripcion` VARCHAR(150) NULL,
  PRIMARY KEY (`id_estado`),
  UNIQUE INDEX `nombre_UNIQUE` (`nombre` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- ---------------------------------------------------------
-- Table `situacion_academica`
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS `situacion_academica` (
  `id_situacion` INT NOT NULL AUTO_INCREMENT,
  `cod_estudiante` VARCHAR(11) NOT NULL,
  `cod_curso` VARCHAR(15) NOT NULL,
  `id_estado` INT NOT NULL,
  `desea_llevar` ENUM('Si', 'No') NULL,
  `prioridad` ENUM('Alta', 'Media', 'Baja') NULL,
  `observacion` VARCHAR(200) NULL,
  `fuente` VARCHAR(50) NOT NULL DEFAULT 'Encuesta' COMMENT 'Encuesta, Docente, etc.',
  `fecha_registro` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_situacion`),
  UNIQUE INDEX `uq_estudiante_curso` (`cod_estudiante` ASC, `cod_curso` ASC) VISIBLE,
  INDEX `fk_Situacion_Estudiante1_idx` (`cod_estudiante` ASC) VISIBLE,
  INDEX `fk_Situacion_Curso1_idx` (`cod_curso` ASC) VISIBLE,
  INDEX `fk_Situacion_Estado1_idx` (`id_estado` ASC) VISIBLE,
  CONSTRAINT `fk_Situacion_Estudiante1`
    FOREIGN KEY (`cod_estudiante`)
    REFERENCES `estudiante` (`cod_estudiante`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Situacion_Curso1`
    FOREIGN KEY (`cod_curso`)
    REFERENCES `curso` (`cod_curso`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Situacion_Estado1`
    FOREIGN KEY (`id_estado`)
    REFERENCES `estado_academico` (`id_estado`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- ---------------------------------------------------------
-- Table `periodo`
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS `periodo` (
  `id_periodo` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(20) NOT NULL COMMENT 'Ej: 2026-I, 2026-II, 2026-Verano',
  `fecha_inicio` DATE NOT NULL,
  `fecha_fin` DATE NOT NULL,
  `tipo` ENUM('Regular', 'Verano') NOT NULL,
  `activo` BOOLEAN NOT NULL DEFAULT TRUE,
  PRIMARY KEY (`id_periodo`),
  UNIQUE INDEX `nombre_UNIQUE` (`nombre` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- ---------------------------------------------------------
-- Table `matricula`
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS `matricula` (
  `id_matricula` INT NOT NULL AUTO_INCREMENT,
  `cod_estudiante` VARCHAR(11) NOT NULL,
  `id_periodo` INT NOT NULL,
  `fecha_matricula` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` ENUM('Matriculado', 'Reservado', 'Retirado') NOT NULL DEFAULT 'Matriculado',
  PRIMARY KEY (`id_matricula`),
  UNIQUE INDEX `uq_estudiante_periodo` (`cod_estudiante` ASC, `id_periodo` ASC) VISIBLE,
  INDEX `fk_Matricula_Estudiante1_idx` (`cod_estudiante` ASC) VISIBLE,
  INDEX `fk_Matricula_Periodo1_idx` (`id_periodo` ASC) VISIBLE,
  CONSTRAINT `fk_Matricula_Estudiante1`
    FOREIGN KEY (`cod_estudiante`)
    REFERENCES `estudiante` (`cod_estudiante`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Matricula_Periodo1`
    FOREIGN KEY (`id_periodo`)
    REFERENCES `periodo` (`id_periodo`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- ---------------------------------------------------------
-- Table `detalle_matricula`
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS `detalle_matricula` (
  `id_detalle` INT NOT NULL AUTO_INCREMENT,
  `id_matricula` INT NOT NULL,
  `cod_curso` VARCHAR(15) NOT NULL,
  `numero_matricula` TINYINT NOT NULL DEFAULT 1 COMMENT 'rango 1 a 4',
  `nota_final` DECIMAL(4,2) NULL,
  `aprobado` BOOLEAN NULL,
  `observacion` VARCHAR(150) NULL,
  PRIMARY KEY (`id_detalle`),
  UNIQUE INDEX `uq_matricula_curso` (`id_matricula` ASC, `cod_curso` ASC) VISIBLE,
  INDEX `fk_Detalle_Matricula1_idx` (`id_matricula` ASC) VISIBLE,
  INDEX `fk_Detalle_Curso1_idx` (`cod_curso` ASC) VISIBLE,
  CONSTRAINT `fk_Detalle_Matricula1`
    FOREIGN KEY (`id_matricula`)
    REFERENCES `matricula` (`id_matricula`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Detalle_Curso1`
    FOREIGN KEY (`cod_curso`)
    REFERENCES `curso` (`cod_curso`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `chk_detalle_numero_matricula` CHECK (`numero_matricula` BETWEEN 1 AND 4),
  CONSTRAINT `chk_detalle_nota` CHECK (`nota_final` IS NULL OR (`nota_final` BETWEEN 0 AND 20)))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;
