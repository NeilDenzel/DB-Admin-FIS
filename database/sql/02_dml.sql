-- ---------------------------------------------------------
-- DML: Datos iniciales BD_SeguimientoAcademico_FIS
-- Adaptado del Capítulo IV para MySQL
-- ---------------------------------------------------------

-- 1. MALLA
INSERT INTO `malla` (`nombre`, `anio_inicio`, `anio_fin`, `vigente`, `resolucion`, `programa_pdf`, `total_creditos`, `descripcion`) VALUES
('Malla 2018-I', 2013, 2022, 0, 'Dato de prueba: pendiente confirmar N° de resolucion con Secretaria Academica', 'MALLAS_2018_2023.pdf', 214.0, 'Plan de estudios para estudiantes admitidos entre 2013 y 2022'),
('Malla 2023-I', 2023, NULL, 1, 'Dato de prueba: pendiente confirmar N° de resolucion con Secretaria Academica', 'MALLAS_2018_2023.pdf', 216.0, 'Plan de estudios vigente para estudiantes admitidos desde 2023');

-- 2. CURSO - Malla 2018-I
INSERT INTO `curso` (`cod_curso`, `nombre`, `ciclo`, `creditos`, `horas_teoria`, `horas_practica`, `tipo`, `id_malla`) VALUES
('EGC011','Matematica I',1,4.0,2,4,'Obligatorio',1),
('EGC012','Comprension Lectora y Redaccion',1,5.0,2,4,'Obligatorio',1),
('EGC013','Realidad Nacional y Globalizacion',1,3.0,2,2,'Obligatorio',1),
('EGC014','Filosofia y Etica',1,4.0,2,4,'Obligatorio',1),
('EGC015','Propedeutica',1,4.0,2,4,'Obligatorio',1),
('EGC021','Matematica II',2,4.0,2,4,'Obligatorio',1),
('EGC022','Fisica General',2,4.0,2,4,'Obligatorio',1),
('EGC023','Relaciones Interpersonales',2,3.0,2,2,'Obligatorio',1),
('EGC024','Ecologia y Medio Ambiente',2,3.0,2,2,'Obligatorio',1),
('EGC025','Desarrollo de Vida y Cultura Universitaria',2,4.0,2,4,'Obligatorio',1),
('IS031A','Analisis Matematico',3,4.0,2,4,'Obligatorio',1),
('IS032A','Geometria Analitica y Vectorial',3,4.0,2,4,'Obligatorio',1),
('IS033A','Introduccion a la Ingenieria de Sistemas',3,4.0,2,4,'Obligatorio',1),
('IS034A','Algoritmia',3,4.0,2,4,'Obligatorio',1),
('IS035A','Fisica',3,4.0,2,4,'Obligatorio',1),
('IS036A','Ingles',3,2.0,1,2,'Obligatorio',1),
('IS041A','Matematica Avanzada',4,4.0,2,4,'Obligatorio',1),
('IS042A','Matematica Discreta',4,4.0,2,4,'Obligatorio',1),
('IS043A','Estadistica I',4,4.0,2,4,'Obligatorio',1),
('IS044A','Teoria Economica',4,4.0,2,4,'Obligatorio',1),
('IS045A','Metodologia de la Programacion',4,4.0,2,4,'Obligatorio',1),
('IS046A','Tecnologias Emergentes',4,2.0,1,2,'Obligatorio',1),
('IS051A','Investigacion de Operaciones',5,4.0,2,4,'Obligatorio',1),
('IS052A','Arquitectura Tecnologica',5,4.0,2,4,'Obligatorio',1),
('IS053A','Estadistica II',5,4.0,2,4,'Obligatorio',1),
('IS054A','Estructura de Datos',5,4.0,2,4,'Obligatorio',1),
('IS055A','Metodologia de Desarrollo del Software',5,4.0,2,4,'Obligatorio',1),
('IS056A','Ingenieria del Conocimiento',5,2.0,1,2,'Obligatorio',1),
('IS061A','Investigacion y Optimizacion Operativa',6,4.0,2,4,'Obligatorio',1),
('IS062A','Redes y Transmision de Informacion',6,4.0,2,4,'Obligatorio',1),
('IS063A','Inteligencia Financiera',6,4.0,2,4,'Obligatorio',1),
('IS064A','Diseno de Base de Datos',6,4.0,2,4,'Obligatorio',1),
('IS065A','Analisis y Diseno de Software',6,4.0,2,4,'Obligatorio',1),
('IS071A','Optimizacion de Procesos',7,4.0,2,4,'Obligatorio',1),
('IS072A','Seguridad de la Informacion',7,4.0,2,4,'Obligatorio',1),
('IS073A','Formulacion de Proyectos',7,4.0,2,4,'Obligatorio',1),
('IS074A','Gestion de Base de Datos',7,4.0,2,4,'Obligatorio',1),
('EIS01A','Electivo I - Ingenieria de Requerimientos',7,4.0,2,4,'Electivo',1),
('ETI01A','Electivo I - Gobierno Electronico',7,4.0,2,4,'Electivo',1),
('EMS01A','Electivo I - Sistema de Gestion ISO',7,4.0,2,4,'Electivo',1),
('IS081A','Innovacion de Tecnologia de Informacion',8,4.0,2,4,'Obligatorio',1),
('IS082A','Gestion Empresarial',8,4.0,2,4,'Obligatorio',1),
('IS083A','Gestion de Proyectos',8,4.0,2,4,'Obligatorio',1),
('IS084A','Metodologia de la Investigacion',8,4.0,2,4,'Obligatorio',1),
('EIS02A','Electivo II - Desarrollo y Calidad del Software',8,4.0,2,4,'Electivo',1),
('ETI02A','Electivo II - Hacking Etico',8,4.0,2,4,'Electivo',1),
('EMS02A','Electivo II - Metodologia Sistemica Blanda',8,4.0,2,4,'Electivo',1),
('IS091A','Inteligencia de Negocios',9,4.0,2,4,'Obligatorio',1),
('IS092A','Gestion de Servicios de Tecnologia de Informacion',9,4.0,2,4,'Obligatorio',1),
('IS093A','Desarrollo de Aplicaciones Web',9,4.0,2,4,'Obligatorio',1),
('IS094A','Seminario de Investigacion',9,4.0,2,4,'Obligatorio',1),
('IS095A','Practicas Preprofesionales',9,2.0,1,2,'Obligatorio',1),
('EIS03A','Electivo III - Sistema de Informacion Geografica',9,4.0,2,4,'Electivo',1),
('ETI03A','Electivo III - Continuidad de Tecnologia de Informacion',9,4.0,2,4,'Electivo',1),
('EMS03A','Electivo III - Dinamica de Sistemas',9,4.0,2,4,'Electivo',1),
('IS101A','Deontologia de la Ingenieria de Sistemas',10,4.0,2,4,'Obligatorio',1),
('IS102A','Auditoria de Tecnologia de Informacion',10,4.0,2,4,'Obligatorio',1),
('IS103A','Desarrollo de Aplicaciones Moviles',10,4.0,2,4,'Obligatorio',1),
('IS104A','Taller de Investigacion',10,4.0,2,4,'Obligatorio',1),
('EIS04A','Electivo IV - Ingenieria de Datos',10,4.0,2,4,'Electivo',1),
('ETI04A','Electivo IV - Gobierno de Tecnologia de Informacion',10,4.0,2,4,'Electivo',1),
('EMS04A','Electivo IV - Cibernetica Organizacional',10,4.0,2,4,'Electivo',1);

-- 3. CURSO - Malla 2023-I
INSERT INTO `curso` (`cod_curso`, `nombre`, `ciclo`, `creditos`, `horas_teoria`, `horas_practica`, `tipo`, `id_malla`) VALUES
('EGI11B','Calculo Diferencial',1,4.0,2,4,'Obligatorio',2),
('EGI12B','Comprension y Redaccion de Textos',1,4.0,2,4,'Obligatorio',2),
('EGI13B','Teoria General de Sistemas',1,4.0,2,4,'Obligatorio',2),
('EGI14B','Fisica General',1,4.0,2,4,'Obligatorio',2),
('EGI15B','Investigacion Formativa',1,3.0,2,2,'Obligatorio',2),
('EGI21B','Calculo Integral',2,4.0,2,4,'Obligatorio',2),
('EGI22B','Filosofia de la Ciencia y Etica',2,3.0,2,2,'Obligatorio',2),
('EGI23B','Relaciones Interpersonales e Interculturalidad',2,3.0,2,2,'Obligatorio',2),
('EGI24B','Medio Ambiente y Desarrollo Sostenible',2,3.0,2,2,'Obligatorio',2),
('EGI25B','Realidad Nacional y Globalizacion',2,3.0,2,2,'Obligatorio',2),
('EGI26B','Responsabilidad Social',2,3.0,2,2,'Obligatorio',2),
('IS031B','Analisis Matematico',3,4.0,2,4,'Obligatorio',2),
('IS032B','Geometria Analitica y Vectorial',3,3.0,2,2,'Obligatorio',2),
('IS033B','Introduccion a la Ingenieria de Sistemas',3,4.0,2,4,'Obligatorio',2),
('IS034B','Algoritmia',3,4.0,2,4,'Obligatorio',2),
('IS035B','Fisica',3,4.0,2,4,'Obligatorio',2),
('IS036B','Ingles',3,2.0,1,2,'Obligatorio',2),
('IS041B','Matematica Avanzada',4,4.0,2,4,'Obligatorio',2),
('IS042B','Matematica Discreta',4,3.0,2,2,'Obligatorio',2),
('IS043B','Estadistica I',4,4.0,2,4,'Obligatorio',2),
('IS044B','Teoria Economica',4,4.0,2,4,'Obligatorio',2),
('IS045B','Metodologia de la Programacion',4,4.0,2,4,'Obligatorio',2),
('IS046B','Tecnologias Emergentes',4,3.0,2,2,'Obligatorio',2),
('IS051B','Investigacion de Operaciones',5,4.0,2,4,'Obligatorio',2),
('IS052B','Arquitectura Tecnologica',5,4.0,2,4,'Obligatorio',2),
('IS053B','Estadistica II',5,4.0,2,4,'Obligatorio',2),
('IS054B','Estructura de Datos',5,3.0,2,2,'Obligatorio',2),
('IS055B','Metodologia de Desarrollo de Software',5,4.0,2,4,'Obligatorio',2),
('IS056B','Ingenieria del Conocimiento',5,3.0,2,2,'Obligatorio',2),
('IS061B','Investigacion y Optimizacion Operativa',6,4.0,2,4,'Obligatorio',2),
('IS062B','Redes y Transmision de Informacion',6,4.0,2,4,'Obligatorio',2),
('IS063B','Inteligencia Financiera',6,4.0,2,4,'Obligatorio',2),
('IS064B','Diseno de Base de Datos',6,4.0,2,4,'Obligatorio',2),
('IS065B','Analisis y Diseno de Software',6,4.0,2,4,'Obligatorio',2),
('IS066B','Discapacidad y Accesibilidad',6,2.0,1,2,'Obligatorio',2),
('EIS01B','Ingenieria de Requerimientos',7,4.0,2,4,'Electivo',2),
('EMS01B','Sistema de Gestion ISO',7,4.0,2,4,'Electivo',2),
('ETI01B','Gobierno Electronico',7,4.0,2,4,'Electivo',2),
('IS071B','Optimizacion de Procesos',7,4.0,2,4,'Obligatorio',2),
('IS072B','Seguridad de la Informacion',7,4.0,2,4,'Obligatorio',2),
('IS073B','Formulacion de Proyectos',7,4.0,2,4,'Obligatorio',2),
('IS074B','Gestion de Base de Datos',7,4.0,2,4,'Obligatorio',2),
('EIS02B','Desarrollo y Calidad de Software',8,4.0,2,4,'Electivo',2),
('EMS02B','Metodologia Sistemica Blanda',8,4.0,2,4,'Electivo',2),
('ETI02B','Hacking Etico',8,4.0,2,4,'Electivo',2),
('IS081B','Innovacion de Tecnologia de Informacion',8,4.0,2,4,'Obligatorio',2),
('IS082B','Gestion Empresarial',8,4.0,2,4,'Obligatorio',2),
('IS083B','Gestion de Proyectos',8,4.0,2,4,'Obligatorio',2),
('IS084B','Metodologia de la Investigacion',8,4.0,2,4,'Obligatorio',2),
('EIS03B','Sistemas de Informacion Geografica',9,4.0,2,4,'Electivo',2),
('EMS03B','Dinamica de Sistemas',9,4.0,2,4,'Electivo',2),
('ETI03B','Continuidad de Tecnologia de Informacion',9,4.0,2,4,'Electivo',2),
('IS091B','Inteligencia de Negocios',9,4.0,2,4,'Obligatorio',2),
('IS092B','Gestion de Servicios de Tecnologia de la Informacion',9,4.0,2,4,'Obligatorio',2),
('IS093B','Desarrollo de Aplicaciones Web',9,4.0,2,4,'Obligatorio',2),
('IS094B','Seminario de Investigacion',9,4.0,2,4,'Obligatorio',2),
('IS095B','Practicas Preprofesionales',9,2.0,1,2,'Obligatorio',2),
('EIS04B','Ingenieria de Datos',10,4.0,2,4,'Electivo',2),
('EMS04B','Cibernetica Organizacional',10,4.0,2,4,'Electivo',2),
('ETI04B','Gobierno de Tecnologia de la Informacion',10,4.0,2,4,'Electivo',2),
('IS101B','Deontologia de la Ingenieria de Sistemas',10,4.0,2,4,'Obligatorio',2),
('IS102B','Auditoria de Tecnologia de la Informacion',10,4.0,2,4,'Obligatorio',2),
('IS103B','Desarrollo de Aplicaciones Moviles',10,4.0,2,4,'Obligatorio',2),
('IS104B','Trabajo de Investigacion',10,4.0,2,4,'Obligatorio',2);

-- 4. PRERREQUISITO - Malla 2018-I
INSERT INTO `prerrequisito` (`cod_curso`, `cod_prerrequisito`) VALUES
('EGC021','EGC011'),
('IS041A','IS031A'),('IS045A','IS034A'),
('IS051A','IS041A'),('IS053A','IS043A'),('IS054A','IS045A'),('IS056A','IS046A'),
('IS061A','IS051A'),('IS062A','IS052A'),('IS064A','IS054A'),('IS065A','IS055A'),
('IS071A','IS061A'),('IS072A','IS062A'),('IS074A','IS064A'),
('IS081A','IS071A'),('IS083A','IS073A'),('IS084A','IS053A'),
('IS091A','IS081A'),('IS092A','IS072A'),('IS093A','IS065A'),('IS094A','IS084A'),
('IS101A','IS092A'),('IS102A','IS093A'),('IS103A','IS094A');

-- PRERREQUISITO - Malla 2023-I
INSERT INTO `prerrequisito` (`cod_curso`, `cod_prerrequisito`) VALUES
('EGI21B','EGI11B'),
('IS041B','IS031B'),('IS045B','IS034B'),
('IS051B','IS041B'),('IS053B','IS043B'),('IS054B','IS045B'),('IS056B','IS046B'),
('IS061B','IS051B'),('IS062B','IS052B'),('IS064B','IS054B'),('IS065B','IS055B'),
('IS071B','IS061B'),('IS072B','IS062B'),('IS074B','IS064B'),
('EIS02B','EIS01B'),('EMS02B','EMS01B'),('ETI02B','ETI01B'),
('IS081B','IS071B'),('IS083B','IS073B'),('IS084B','IS053B'),
('EIS03B','EIS02B'),('EMS03B','EMS02B'),('ETI03B','ETI02B'),
('IS091B','IS081B'),('IS092B','IS072B'),('IS093B','IS065B'),('IS094B','IS084B'),
('EIS04B','EIS03B'),('EMS04B','EMS03B'),('ETI04B','ETI03B'),
('IS102B','IS092B'),('IS103B','IS093B'),
('IS104B','IS094B'),('IS104B','IS095B');

-- 5. ESTADO_ACADEMICO
INSERT INTO `estado_academico` (`nombre`, `descripcion`) VALUES
('Aprobado','El estudiante curso y aprobo la asignatura'),
('Desaprobado','El estudiante curso la asignatura y no la aprobo'),
('En Peligro','El estudiante reporta riesgo de desaprobar la asignatura en curso'),
('Pendiente','Curso adeudado de un semestre o malla anterior, aun no regularizado'),
('No Llevado','El estudiante aun no ha cursado la asignatura');

-- 6. PERIODO
INSERT INTO `periodo` (`nombre`, `fecha_inicio`, `fecha_fin`, `tipo`, `activo`) VALUES
('2026-I','2026-03-16','2026-07-25','Regular',1);

-- 7. ESTUDIANTE
INSERT INTO `estudiante` (`cod_estudiante`, `dni`, `nombres`, `apellidos`, `sexo`, `ciclo_actual`) VALUES
('2026100990','60829470','Shamir Yair','Apolinario Turin','M',1),
('2026100992','60906593','Jose Manuel','Aylas Maita','M',1),
('2026100993','75202155','Roselyno Emerson','Canchanya Ynga','M',1),
('2026100995','61484848','Estrelit Isamar','Caysahuana Gutierrez','F',1),
('2026101000','61445094','Danika Geraldine','Guerra Ramos','F',1),
('2026101012','61648924','Alinson Jack','Salome Rodriguez','M',1),
('2026101015','61028220','Jack Angel','Taipe Taquire','M',1),
('2018200441','72123008','Alexander Pool','Carbajal Arana','M',9),
('2015100986','70297211','Erick Antonio','Castro Ordonez','M',9),
('2013100969','48336779','Mario Maximo','Coca Huari','M',9),
('2020100534','72231584','Adrian Leonardo','Guillen Lermo','M',10),
('2021200798','73797559','Rolando Raul','Rojas Quispe','M',8),
('2011200769','48542606','Juan Carlos','Ganoza Gutarra','M',9),
('2018200461','71648837','Stefano Carlos','Soto Fabian','M',10),
('2023200771','73034831','Jim Jhordan','Balvin Marcos','M',10);

-- 8. SITUACION_ACADEMICA
-- Resolviendo los EXEC sp_RegistrarSituacionAcademica a INSERTs directos
-- id_estado: 1=Aprobado, 2=Desaprobado, 3=En Peligro, 4=Pendiente, 5=No Llevado

-- Stefano Carlos Soto Fabian (2018200461)
INSERT INTO `situacion_academica` (`cod_estudiante`, `cod_curso`, `id_estado`, `desea_llevar`, `prioridad`, `observacion`, `fuente`) VALUES
('2018200461','IS101A',3,NULL,NULL,'Autoreporte encuesta 2026-I','Encuesta 2026-I'),
('2018200461','IS102A',1,NULL,NULL,NULL,'Encuesta 2026-I'),
('2018200461','IS103A',2,NULL,NULL,NULL,'Encuesta 2026-I'),
('2018200461','IS104A',2,NULL,NULL,NULL,'Encuesta 2026-I'),
('2018200461','IS083A',4,'Si','Alta','Curso adeudado de VIII ciclo; dispuesto a llevarlo en verano','Encuesta 2026-I'),
('2018200461','IS091A',4,'Si','Alta','Curso adeudado de IX ciclo; dispuesto a llevarlo en verano','Encuesta 2026-I');

-- Adrian Leonardo Guillen Lermo (2020100534)
INSERT INTO `situacion_academica` (`cod_estudiante`, `cod_curso`, `id_estado`, `desea_llevar`, `prioridad`, `observacion`, `fuente`) VALUES
('2020100534','IS101A',1,NULL,NULL,NULL,'Encuesta 2026-I'),
('2020100534','IS102A',1,NULL,NULL,NULL,'Encuesta 2026-I'),
('2020100534','IS103A',2,NULL,NULL,NULL,'Encuesta 2026-I'),
('2020100534','IS104A',1,NULL,NULL,NULL,'Encuesta 2026-I'),
('2020100534','IS063A',4,'Si','Media','Curso adeudado de VI ciclo (Inteligencia Financiera); dispuesto a llevarlo en verano','Encuesta 2026-I');

-- Juan Carlos Ganoza Gutarra (2011200769)
INSERT INTO `situacion_academica` (`cod_estudiante`, `cod_curso`, `id_estado`, `desea_llevar`, `prioridad`, `observacion`, `fuente`) VALUES
('2011200769','IS091A',1,NULL,NULL,NULL,'Encuesta 2026-I'),
('2011200769','IS092A',1,NULL,NULL,NULL,'Encuesta 2026-I'),
('2011200769','IS093A',2,NULL,NULL,NULL,'Encuesta 2026-I'),
('2011200769','IS094A',2,NULL,NULL,NULL,'Encuesta 2026-I'),
('2011200769','IS095A',1,NULL,NULL,NULL,'Encuesta 2026-I');

-- Rolando Raul Rojas Quispe (2021200798)
INSERT INTO `situacion_academica` (`cod_estudiante`, `cod_curso`, `id_estado`, `desea_llevar`, `prioridad`, `observacion`, `fuente`) VALUES
('2021200798','IS081A',5,NULL,NULL,NULL,'Encuesta 2026-I'),
('2021200798','IS082A',1,NULL,NULL,NULL,'Encuesta 2026-I'),
('2021200798','IS083A',1,NULL,NULL,NULL,'Encuesta 2026-I'),
('2021200798','IS084A',1,NULL,NULL,NULL,'Encuesta 2026-I'),
('2021200798','IS093A',4,'Si','Alta','Curso adeudado de IX ciclo (Desarrollo de Aplicaciones Web)','Encuesta 2026-I'),
('2021200798','IS092A',4,'Si','Media','Curso adeudado de IX ciclo (Gestion de Servicios TI)','Encuesta 2026-I'),
('2021200798','IS091A',4,'Si','Media','Curso adeudado de IX ciclo (Inteligencia de Negocios)','Encuesta 2026-I');
