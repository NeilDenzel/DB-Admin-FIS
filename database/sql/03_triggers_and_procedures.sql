-- ---------------------------------------------------------
-- Objetos SQL del Capítulo IV
-- Adaptados a MySQL 8.x
-- ---------------------------------------------------------
-- NOTA: No usar DELIMITER. DB::unprepared() envía directamente
-- a PDO/MySQL con soporte multi-statement.
-- ---------------------------------------------------------

-- =========================================================
-- TRIGGER: Asigna malla automáticamente según año de ingreso
-- Los primeros 4 dígitos del cod_estudiante = año de ingreso
-- Pág. 36 (Figura 18) del documento oficial
-- =========================================================
DROP TRIGGER IF EXISTS trg_Estudiante_AsignarMalla;
CREATE TRIGGER trg_Estudiante_AsignarMalla
BEFORE INSERT ON estudiante
FOR EACH ROW
BEGIN
    DECLARE anio_ingreso INT DEFAULT 0;
    DECLARE v_id_malla INT;
    IF NEW.cod_estudiante IS NOT NULL AND LENGTH(NEW.cod_estudiante) >= 4 THEN
        SET anio_ingreso = CAST(LEFT(NEW.cod_estudiante, 4) AS UNSIGNED);
        IF anio_ingreso BETWEEN 2013 AND 2022 THEN
            SET v_id_malla = 1;
        ELSEIF anio_ingreso >= 2023 THEN
            SET v_id_malla = 2;
        END IF;
        IF v_id_malla IS NOT NULL THEN
            SET NEW.id_malla = v_id_malla;
        END IF;
    END IF;
END;

-- =========================================================
-- STORED PROCEDURE: Registra o actualiza situación académica
-- Pág. 32 (Figura 12) del documento oficial
-- =========================================================
DROP PROCEDURE IF EXISTS sp_RegistrarSituacionAcademica;
CREATE PROCEDURE sp_RegistrarSituacionAcademica(
    IN p_cod_estudiante VARCHAR(11),
    IN p_cod_curso VARCHAR(15),
    IN p_estado_nombre VARCHAR(40),
    IN p_desea_llevar ENUM('Si','No'),
    IN p_prioridad ENUM('Alta','Media','Baja'),
    IN p_observacion VARCHAR(200),
    IN p_fuente VARCHAR(50)
)
BEGIN
    DECLARE v_id_estado INT;
    DECLARE v_existe INT;
    SELECT id_estado INTO v_id_estado
    FROM estado_academico
    WHERE nombre = p_estado_nombre
    LIMIT 1;
    IF v_id_estado IS NULL THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Estado académico no encontrado';
    END IF;
    SELECT COUNT(*) INTO v_existe
    FROM situacion_academica
    WHERE cod_estudiante = p_cod_estudiante AND cod_curso = p_cod_curso;
    IF v_existe > 0 THEN
        UPDATE situacion_academica
        SET id_estado = v_id_estado, desea_llevar = p_desea_llevar,
            prioridad = p_prioridad, observacion = p_observacion,
            fuente = COALESCE(p_fuente, 'Importación')
        WHERE cod_estudiante = p_cod_estudiante AND cod_curso = p_cod_curso;
    ELSE
        INSERT INTO situacion_academica
            (cod_estudiante, cod_curso, id_estado, desea_llevar, prioridad, observacion, fuente)
        VALUES
            (p_cod_estudiante, p_cod_curso, v_id_estado, p_desea_llevar,
             p_prioridad, p_observacion, COALESCE(p_fuente, 'Importación'));
    END IF;
END;

-- =========================================================
-- VISTA: Estudiantes en Rezago Académico
-- Muestra estudiantes con estado distinto de 'Aprobado'
-- Pág. 31 (Figura 11) del documento oficial
-- =========================================================
DROP VIEW IF EXISTS vw_EstudiantesRezago;
CREATE VIEW vw_EstudiantesRezago
AS
SELECT
    e.cod_estudiante,
    e.apellidos,
    e.nombres,
    c.cod_curso,
    c.nombre AS curso,
    ea.nombre AS estado
FROM Estudiante e
INNER JOIN Situacion_Academica sa ON e.cod_estudiante = sa.cod_estudiante
INNER JOIN Curso c ON sa.cod_curso = c.cod_curso
INNER JOIN Estado_Academico ea ON sa.id_estado = ea.id_estado
WHERE ea.nombre <> 'Aprobado';

-- =========================================================
-- STORED PROCEDURE: Buscar Estudiante por código
-- Retorna el historial académico completo de un estudiante
-- Pág. 32-33 (Figura 13) del documento oficial
-- =========================================================
DROP PROCEDURE IF EXISTS sp_BuscarEstudiante;
CREATE PROCEDURE sp_BuscarEstudiante(IN p_codigo VARCHAR(20))
BEGIN
    SELECT
        e.cod_estudiante,
        e.apellidos,
        e.nombres,
        c.cod_curso,
        c.nombre,
        ea.nombre AS estado
    FROM Estudiante e
    INNER JOIN Situacion_Academica sa ON e.cod_estudiante = sa.cod_estudiante
    INNER JOIN Curso c ON sa.cod_curso = c.cod_curso
    INNER JOIN Estado_Academico ea ON sa.id_estado = ea.id_estado
    WHERE e.cod_estudiante = p_codigo;
END;

-- =========================================================
-- FUNCIÓN: Total de Cursos Pendientes
-- Calcula la cantidad de cursos que un estudiante mantiene
-- en estado distinto de 'Aprobado'
-- Pág. 34 (Figura 15) del documento oficial
-- =========================================================
DROP FUNCTION IF EXISTS fn_TotalCursosPendientes;
CREATE FUNCTION fn_TotalCursosPendientes(p_codigo VARCHAR(20))
RETURNS INT
DETERMINISTIC
READS SQL DATA
BEGIN
    DECLARE v_total INT;
    SELECT COUNT(*) INTO v_total
    FROM Situacion_Academica sa
    INNER JOIN Estado_Academico ea ON sa.id_estado = ea.id_estado
    WHERE sa.cod_estudiante = p_codigo AND ea.nombre <> 'Aprobado';
    RETURN v_total;
END;

-- =========================================================
-- TRIGGER: Fecha de Registro Automática
-- Registra automáticamente la fecha y hora de inserción
-- de nuevos registros en Situacion_Academica
-- Pág. 35 (Figura 17) del documento oficial
-- =========================================================
DROP TRIGGER IF EXISTS trg_FechaRegistro;
CREATE TRIGGER trg_FechaRegistro
BEFORE INSERT ON situacion_academica
FOR EACH ROW
BEGIN
    SET NEW.fecha_registro = NOW();
END;
