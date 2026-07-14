# DB-Admin-FIS

Plataforma de administración académica para el seguimiento de la situación académica de los estudiantes de la **Facultad de Ingeniería de Sistemas (FIS)** de la UNCP.

## Tecnologías

| Componente | Versión |
|---|---|
| Laravel | 11.6.1 |
| PHP | 8.5.7 |
| MySQL | 8.x |
| Composer | 2.10.1 |

## Base de Datos

**Nombre:** `BD_SeguimientoAcademico_FIS`

### Esquema (9 tablas)

```
malla ──┬── curso ──── prerrequisito (N:M reflexiva)
         │
         └── estudiante ──┬── situacion_academica ──── estado_academico
                          │
                          └── matricula ──── detalle_matricula ──── periodo
```

### Tablas

| Tabla | Propósito |
|---|---|
| `malla` | Planes curriculares (Malla 2018-I, Malla 2023-I) |
| `curso` | Catálogo de asignaturas por malla |
| `prerrequisito` | Relación N:M reflexiva entre cursos |
| `estudiante` | Padrón de estudiantes |
| `estado_academico` | Catálogo de estados (Aprobado, Desaprobado, Pendiente, etc.) |
| `situacion_academica` | Estado de cada estudiante en cada curso (tabla puente) |
| `periodo` | Periodos académicos (ej. 2026-I) |
| `matricula` | Matrícula de estudiantes por periodo |
| `detalle_matricula` | Cursos matriculados por estudiante en un periodo |

### Datos iniciales

- 2 mallas (2018-I y 2023-I)
- 118 cursos (60 de Malla 2018-I + 58 de Malla 2023-I)
- 54 prerrequisitos
- 5 estados académicos
- 15 estudiantes reales del padrón 2026-I
- 23 registros de situación académica de la encuesta 2026-I (4 estudiantes)
- 1 periodo (2026-I)

## Modelos Eloquent

| Modelo | Tabla | PK | Timestamps |
|---|---|---|---|
| `Malla` | malla | id_malla (int) | false |
| `Curso` | curso | cod_curso (string) | false |
| `Estudiante` | estudiante | cod_estudiante (string) | fecha_registro |
| `EstadoAcademico` | estado_academico | id_estado (int) | false |
| `SituacionAcademica` | situacion_academica | id_situacion (int) | fecha_registro |
| `Periodo` | periodo | id_periodo (int) | false |
| `Matricula` | matricula | id_matricula (int) | fecha_matricula |
| `DetalleMatricula` | detalle_matricula | id_detalle (int) | false |

### Relaciones principales

- `Malla` ⟶ hasMany `Curso`, hasMany `Estudiante`
- `Curso` ⟶ belongsTo `Malla`, belongsToMany `Curso` (prerrequisitos)
- `Estudiante` ⟶ belongsTo `Malla`, hasMany `SituacionAcademica`, hasMany `Matricula`
- `SituacionAcademica` ⟶ belongsTo `Estudiante`, `Curso`, `EstadoAcademico`
- `Matricula` ⟶ belongsTo `Estudiante`, `Periodo`, hasMany `DetalleMatricula`

## Instalación

```bash
# 1. Clonar el repositorio
git clone <repo-url>
cd DB-Admin-FIS

# 2. Instalar dependencias
composer install

# 3. Configurar variables de entorno
cp .env.example .env
# Editar .env con credenciales de MySQL

# 4. Generar APP_KEY
php artisan key:generate

# 5. Ejecutar migraciones (crea BD, tablas y carga datos)
php artisan migrate --force
```

## Migraciones

El proyecto usa **SQL crudo** ejecutado con `DB::unprepared()` para preservar el esquema original (DDL de MySQL Workbench) sin reescribirlo con el Schema Builder de Laravel.

Archivos SQL en `database/sql/`:

| Archivo | Contenido |
|---|---|
| `00_create_database.sql` | CREATE DATABASE IF NOT EXISTS |
| `01_ddl.sql` | DDL de las 9 tablas con FK, índices y CHECK |
| `02_dml.sql` | Datos iniciales (INSERTs) |

## Créditos

Proyecto basado en el diseño de base de datos del Capítulo IV de la tesis:  
_"Diseño e implementación de una base de datos para el seguimiento de la situación académica de los estudiantes de la FIS - UNCP"_
