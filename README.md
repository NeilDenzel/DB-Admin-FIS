# DB-Admin-FIS

Plataforma de administración académica para el seguimiento de la situación académica de los estudiantes de la **Facultad de Ingeniería de Sistemas (FIS)** de la UNCP.

> Basado en el diseño de base de datos del Capítulo IV de la tesis:  
> _"Diseño e implementación de una base de datos para el seguimiento de la situación académica de los estudiantes de la FIS - UNCP"_

---

## Stack Tecnológico

| Componente | Versión |
|---|---|
| Laravel | 11.6.1 |
| PHP | 8.5.7 |
| MySQL | 8.x |
| Composer | 2.10.1 |
| Node.js | — |
| Tailwind CSS | CDN v3 + Vite v6 |
| Alpine.js | 3.x (CDN) |
| maatwebsite/Laravel-Excel | ^3.1 |

---

## Base de Datos

**Motor:** MySQL 8.x  
**Nombre:** `BD_SeguimientoAcademico_FIS`

### Esquema Entidad-Relación

```
malla ──┬── curso ──── prerrequisito (N:M reflexiva)
         │
         ├── estudiante ──┬── situacion_academica ──── estado_academico
         │                 │
         │                 └── matricula ──── detalle_matricula ──── periodo
         │                 │
         └── (trigger)     └── (stored procedure)
```

### Tablas

| Tabla | Propósito | Columnas clave |
|---|---|---|
| `malla` | Planes curriculares (Malla 2018-I, Malla 2023-I) | `id_malla`, `nombre`, `anio_inicio`, `anio_fin`, `vigente` |
| `curso` | Catálogo de asignaturas por malla | `cod_curso` (PK string), `nombre`, `ciclo`, `creditos`, `id_malla` (FK), `tipo` (Obligatorio/Electivo) |
| `prerrequisito` | Relación N:M reflexiva entre cursos | `cod_curso` (FK), `cod_prerrequisito` (FK) |
| `estudiante` | Padrón de estudiantes | `cod_estudiante` (PK string), `dni`, `nombres`, `apellidos`, `id_malla` (FK, asignado por trigger), `ciclo_actual` |
| `estado_academico` | Catálogo de estados (Aprobado, Desaprobado, En Peligro, Pendiente, No Llevado) | `id_estado`, `nombre`, `descripcion` |
| `situacion_academica` | Estado de cada estudiante en cada curso (tabla puente) | `id_situacion`, `cod_estudiante` (FK), `cod_curso` (FK), `id_estado` (FK), `desea_llevar`, `prioridad`, `fuente` |
| `periodo` | Periodos académicos (Regular/Verano) | `id_periodo`, `nombre`, `fecha_inicio`, `fecha_fin`, `activo` |
| `matricula` | Matrícula de estudiantes por periodo | `id_matricula`, `cod_estudiante` (FK), `id_periodo` (FK), `estado` (Matriculado/Reservado/Retirado) |
| `detalle_matricula` | Cursos matriculados por estudiante en un periodo | `id_detalle`, `id_matricula` (FK), `cod_curso` (FK), `numero_matricula`, `nota_final`, `aprobado` |
| `users` | Usuarios admin del sistema (Laravel Auth) | `id`, `name`, `email`, `password` |

### Objetos SQL (Capítulo IV)

| Tipo | Objeto | Archivo | Propósito | Pág. |
|---|---|---|---|---|
| Trigger | `trg_Estudiante_AsignarMalla` | `03_triggers_and_procedures.sql` | BEFORE INSERT en `estudiante`. Extrae los primeros 4 dígitos de `cod_estudiante` como año de ingreso y asigna `id_malla` automáticamente: 2013–2022 → malla 1, ≥2023 → malla 2 | 36 |
| Stored Procedure | `sp_RegistrarSituacionAcademica` | `03_triggers_and_procedures.sql` | Upsert centralizado de situación académica. Valida que el estado exista. | 32 |
| Vista | `vw_EstudiantesRezago` | `03_triggers_and_procedures.sql` | Muestra estudiantes con cursos en estado distinto de "Aprobado" (Desaprobado, En Peligro, Pendiente, No Llevado). Usada por el módulo de Reportes. | 31 |
| Stored Procedure | `sp_BuscarEstudiante` | `03_triggers_and_procedures.sql` | Retorna el historial académico completo de un estudiante a partir de su código institucional. | 32-33 |
| Function | `fn_TotalCursosPendientes` | `03_triggers_and_procedures.sql` | Calcula la cantidad de cursos que un estudiante mantiene en estado distinto de "Aprobado". | 34 |
| Trigger | `trg_FechaRegistro` | `03_triggers_and_procedures.sql` | BEFORE INSERT en `situacion_academica`. Asigna automáticamente la fecha y hora de registro. | 35 |

### Datos iniciales

- 2 mallas (2018-I y 2023-I)
- 126 cursos (Obligatorios + Electivos)
- 54 prerrequisitos
- 5 estados académicos
- 15 estudiantes reales del padrón 2026-I
- 23 registros de situación académica de la encuesta 2026-I
- 1 periodo (2026-I)
- 4 usuarios admin (decano, director escuela, director departamento, administrativo)

---

## Migraciones

El proyecto usa **SQL crudo** ejecutado con `DB::unprepared()` para preservar el esquema original (DDL de MySQL Workbench).

| Migración | Archivo SQL | Contenido |
|---|---|---|
| `*_create_initial_schema_from_raw_sql` | `database/sql/00_create_database.sql` | `CREATE DATABASE IF NOT EXISTS` |
| | `database/sql/01_ddl.sql` | DDL de las 9 tablas con FK, índices y CHECK |
| | `database/sql/02_dml.sql` | Datos iniciales (INSERTs) |
| `*_create_triggers_and_procedures` | `database/sql/03_triggers_and_procedures.sql` | 2 triggers, 2 SP, 1 función, 1 vista |

---

## Modelos Eloquent

| Modelo | Tabla | PK | Timestamps | `$guarded` | Relaciones |
|---|---|---|---|---|---|
| `Malla` | malla | id_malla (int) | ❌ | — | hasMany `Curso`, hasMany `Estudiante` |
| `Curso` | curso | cod_curso (string) | ❌ | — | belongsTo `Malla`, belongsToMany `Curso` (prerrequisitos) |
| `Estudiante` | estudiante | cod_estudiante (string) | fecha_registro | `[]` | belongsTo `Malla`, hasMany `SituacionAcademica`, hasMany `Matricula` |
| `EstadoAcademico` | estado_academico | id_estado (int) | ❌ | — | — |
| `SituacionAcademica` | situacion_academica | id_situacion (int) | fecha_registro | — | belongsTo `Estudiante`, `Curso`, `EstadoAcademico` |
| `Periodo` | periodo | id_periodo (int) | ❌ | `[]` | hasMany `Matricula` |
| `Matricula` | matricula | id_matricula (int) | fecha_matricula | `[]` | belongsTo `Estudiante`, `Periodo`, hasMany `DetalleMatricula` |
| `DetalleMatricula` | detalle_matricula | id_detalle (int) | ❌ | `[]` | belongsTo `Matricula`, `Curso` |
| `User` | users | id (int) | ✓ | — | Autenticación Laravel por defecto |

---

## Rutas — Módulos del sistema

### Rutas públicas (sin autenticación)

| Método | URI | Controlador | Vista | Descripción |
|---|---|---|---|---|
| GET | `/login` | `Auth\LoginController@create` | `auth.login` | Formulario de inicio de sesión |
| POST | `/login` | `Auth\LoginController@store` | — | Procesa credenciales |
| POST | `/logout` | `Auth\LoginController@destroy` | — | Cierra sesión |
| GET | `/verano-quorum` | `PublicController@quorum` | `public.quorum` 📄 | Vista pública del quórum de verano |

### Rutas admin (requieren autenticación, prefijo `/admin`)

| Método | URI | Controlador | Vista | Estado |
|---|---|---|---|---|
| GET | `/admin/dashboard` | `AdminDashboardController@index` | `admin.dashboard` 📄 | ✅ Implementado |
| GET | `/admin/electivos` | `AdminElectivosController@index` | `admin.electivos` 📄 | ⏳ Placeholder (sin lógica) |
| GET | `/admin/reportes` | `AdminReportesController@index` | `admin.reportes` 📄 | ✅ Consulta `vw_EstudiantesRezago` |
| GET | `/admin/importar` | `AdminImportController@index` | `admin.importar` 📄 | ✅ Implementado |
| POST | `/admin/importar/estudiantes` | `AdminImportController@importEstudiantes` | — | ✅ Implementado |
| POST | `/admin/importar/situacion` | `AdminImportController@importSituacion` | — | ✅ Implementado |
| POST | `/admin/importar/notas` | `AdminImportController@importNotas` | — | ✅ Implementado |

### Módulos pendientes por implementar

| Módulo | Ruta | Controlador | Vista existente | ¿Qué falta? |
|---|---|---|---|---|
| **Electivos** | `/admin/electivos` | `AdminElectivosController` | ✅ `admin.electivos` | CRUD de sondeo de cursos electivos (votación estudiantes, resultados por curso) |
| **Reportes** | `/admin/reportes` | `AdminReportesController` | ✅ `admin.reportes` | ✅ Tabla de rezago desde `vw_EstudiantesRezago`. Pendiente: gráficos Chart.js, tendencias, exportación PDF |
| **Gestión de Cursos** | — | — | ❌ | CRUD completo de cursos, prerrequisitos, asignación a mallas |
| **Gestión de Mallas** | — | — | ❌ | CRUD de planes curriculares, activación/desactivación |
| **Gestión de Estudiantes** | — | — | ❌ | CRUD de estudiantes, búsqueda, edición de malla asignada |
| **Gestión de Docentes** | — | — | ❌ | Registro de docentes, asignación a cursos |
| **Horarios** | — | — | ❌ | Asignación de horarios por curso/periodo |
| **APIs REST** | `/api/*` | — | ❌ | Endpoints JSON para integración con sistemas externos |
| **Logo institucional** | — | — | ❌ | Colocar archivo `logo-fis.png` en `public/images/` |

---

## Vistas — Interfaz de usuario

### Layouts

| Archivo | Descripción |
|---|---|
| `layouts/admin.blade.php` | **Layout principal del panel admin.** Sidebar blanco inline con iconos SVG, navbar superior translúcida con avatar gradiente, main con fondo mesh gradient. Responsivo con menú móvil vía Alpine.js. Incluye botón de logout con confirmación. |
| `layouts/public.blade.php` | Layout público centrado con mesh gradient, título en blue-600, sin sidebar. |

### Vistas admin

| Ruta | Archivo | Descripción | Componentes UI |
|---|---|---|---|
| `/admin/dashboard` | `admin/dashboard.blade.php` | Tabla con semáforo de quórum de verano por curso. Badge de color (verde ≥8, amarillo 5-7, rojo <5). Botón "Detalle" con efecto Interactive Hover Button. | Tabla Data-Dense rounded-3xl, Badges semáforo, Interactive Hover Button |
| `/admin/electivos` | `admin/electivos.blade.php` | Placeholder con título y descripción. Pendiente de implementar. | — |
| `/admin/reportes` | `admin/reportes.blade.php` | Tabla de estudiantes en rezago académico consultando `vw_EstudiantesRezago`. Badge de estado por color (rojo=Desaprobado, amarillo=En Peligro, naranja=Pendiente, gris=No Llevado). Contador de registros. | Tabla Data-Dense rounded-3xl, Badges de estado, thead bg-blue-50/50 |
| `/admin/importar` | `admin/importar.blade.php` | 3 tarjetas de upload de Excel (Estudiantes, Situación Académica, Notas Históricas). Cada una con: input file estilizado, columnas esperadas, botón gradiente azul, alertas flash de éxito/error. | Cards rounded-3xl, Input file personalizado, Botón gradiente |

### Vistas de autenticación

| Ruta | Archivo | Descripción |
|---|---|---|
| `/login` | `auth/login.blade.php` | Página de login standalone. Header con logo FIS (fallback onerror), título "Iniciar Sesión", card rounded-3xl con input group, botón gradiente azul. Mesh gradient de fondo con grid pattern. |

### Vistas públicas

| Ruta | Archivo | Descripción | Componentes UI |
|---|---|---|---|
| `/verano-quorum` | `public/quorum.blade.php` | Bento Grid de tarjetas con barra de progreso por curso. Muestra estudiantes interesados y semáforo visual. Diseño responsivo (1→2→3 columnas). | Bento Grid, Progress Bar con gradiente, Text Reveal, Badges semáforo |

### Componentes reutilizables

| Archivo | Descripción |
|---|---|
| `components/admin/sidebar.blade.php` | Menú vertical con 4 enlaces (Dashboard, Electivos, Reportes, Importar), iconos SVG inline, active state azul gradiente. |
| `components/admin/navbar.blade.php` | Barra superior: botón hamburguesa (móvil), título dinámico con Alpine.js, avatar con gradiente azul. |

### Componentes React (21st.dev)

> Ruta: `components/ui/` — Preparados para futura migración a Vite + React. No integrados actualmente en las vistas Blade.

| Archivo | Descripción |
|---|---|
| `bento-grid.tsx` | Cuadrícula asimétrica de tarjetas con `BentoGrid`, `BentoCard`, `BentoTitle`, `BentoDescription`, `BentoContent` y `BentoGridWithFeatures`. |
| `text-reveal.tsx` | Componente `TextRevealByWord` que revela palabras una por una al hacer scroll, usando `framer-motion` + `useScroll`. |
| `interactive-hover-button.tsx` | Botón interactivo con estados idle → loading → success. Animaciones con `framer-motion` y `lucide-react`. |
| `light-gradient-background.tsx` | Fondo mesh gradient claro con patrones geométricos y diagonales. Adaptado a tema corporativo claro. |

---

## Módulo de Importación (Excel)

### Dependencia

`maatwebsite/excel` ^3.1 — Basado en PhpSpreadsheet.

### Clases Import

| Clase | Archivo | Estrategia | Columnas requeridas |
|---|---|---|---|
| `EstudiantesImport` | `app/Imports/EstudiantesImport.php` | `ToModel` + `WithValidation`. El trigger `trg_Estudiante_AsignarMalla` asigna `id_malla` automáticamente. | `cod_estudiante`, `dni`, `nombres`, `apellidos`, `correo`, `telefono`, `sexo`, `ciclo_actual` |
| `SituacionAcademicaImport` | `app/Imports/SituacionAcademicaImport.php` | `OnEachRow` — cada fila ejecuta `CALL sp_RegistrarSituacionAcademica(...)`. | `cod_estudiante`, `cod_curso`, `estado`, `desea_llevar`, `prioridad`, `observacion` |
| `NotasHistoricasImport` | `app/Imports/NotasHistoricasImport.php` | `OnEachRow` — cada fila crea periodo, matrícula y detalle_matricula en transacción. | `cod_estudiante`, `periodo`, `cod_curso`, `numero_matricula`, `nota_final`, `aprobado` |

### Archivos de prueba

Generados con `php artisan app:generate-test-excel` en `storage/app/test_import/`:

```
test_estudiantes.xlsx            — 5 estudiantes (años 2019-2024)
test_situacion_academica.xlsx    — 7 registros (5 estados diferentes)
test_notas_historicas.xlsx       — 6 notas (3 periodos, 4 matrículas)
```

---

## Autenticación

Login personalizado (no Laravel Breeze/Jetstream):

| Componente | Archivo |
|---|---|
| Controlador | `app/Http/Controllers/Auth/LoginController.php` |
| Vista | `resources/views/auth/login.blade.php` |
| Seeders | `database/seeders/AdminUserSeeder.php` (4 usuarios) |

### Usuarios predefinidos

| Nombre | Email | Rol |
|---|---|---|
| Decano | decano@fis.edu.pe | Decano de la facultad |
| Director Escuela | director.escuela@fis.edu.pe | Director de la Escuela Profesional |
| Director Departamento | director.departamento@fis.edu.pe | Director del Departamento Académico |
| Administrativo | administrativo@fis.edu.pe | Personal administrativo |

Todos los usuarios tienen contraseña: `password`

---

## Semáforo de Quórum

| Interesados | Badge | Clase Tailwind | Interpretación |
|---|---|---|---|
| ≥ 8 | Verde | `bg-green-100 text-green-800` | Cumple Quórum — el curso puede abrirse |
| 5-7 | Amarillo | `bg-yellow-100 text-yellow-800` | Por alcanzar — necesita difusión |
| < 5 | Rojo | `bg-red-100 text-red-800` | Demanda baja — no abre |

**Meta:** 8 estudiantes para abrir un curso de verano.

**Filtro de datos:** `situacion_academica` WHERE `desea_llevar = 'Si'` OR `id_estado IN (2,4)` (Desaprobado o Pendiente).

---

## Diseño UI/UX — "Soft UI Evolution"

### Estilo general

- **Tema:** Light Mode obligatorio
- **Enfoque:** Interfaz corporativa limpia, profesional y accesible
- **Fondo:** Mesh gradient suave con patrones geométricos (`radial-gradient` + grid pattern rgba azul)
- **Tarjetas:** Blancas (`bg-white`), bordes sutiles (`border-slate-100`), sombras difuminadas, esquinas `rounded-3xl`

### Paleta de colores

| Token | Valor CSS | Uso |
|---|---|---|
| Azul corporativo | `#2563eb` (blue-600) | Botones primarios, títulos, enlaces activos, gradientes |
| Cyan corporativo | `#06b6d4` (cyan-500) | Gradientes, acentos secundarios |
| Fondo principal | `#f8fafc` (slate-50) | Mesh gradient, body |
| Tarjetas | `#ffffff` (white) | Cards, sidebar, navbar |
| Texto principal | `#0f172a` (slate-900) | Títulos, contenido |
| Texto secundario | `#64748b` (slate-500) | Subtítulos, etiquetas |
| Bordes | `#e2e8f0` (slate-200) | Separadores, borders |
| Sombra azulada | `rgba(133,189,215,0.88)` | Hover effects, cards |
| Verde quórum | `#22c55e` (green-500) | Badge ≥8 |
| Amarillo quórum | `#eab308` (yellow-500) | Badge 5-7 |
| Rojo quórum | `#ef4444` (red-400) | Badge <5 |
| Azul progreso | `#3b82f6` (blue-500) | Barra de progreso al completar |

### Tokens de diseño

| Propiedad | Valor |
|---|---|
| Border radius (cards) | `rounded-2xl` / `rounded-3xl` |
| Border radius (botones) | `rounded-xl` / `rounded-lg` |
| Sombras | `shadow-sm` / `shadow-md` / `shadow-[0_5px_10px_-5px_rgba(133,189,215,0.88)]` |
| Transiciones | `transition-all duration-300` |
| Espaciado tarjetas | `gap-6` / `p-6` / `p-8` |
| Sidebar | `w-64`, `bg-white`, `border-r border-slate-200` |
| Navbar | `h-16`, translúcido con `backdrop-blur-xl bg-white/70` |
| Inputs | `rounded-xl border-slate-200`, foco `ring-2 ring-blue-500/20 border-blue-600` |

### Patrones de fondo

El mesh gradient se compone de:
```css
radial-gradient(ellipse 70% 55% at 10% 15%, rgba(219,234,254,0.6), transparent)
radial-gradient(ellipse 60% 45% at 90% 85%, rgba(191,219,254,0.35), transparent)
linear-gradient(180deg, #f8fafc, #ffffff, #f1f5f9)
```
Superpuesto con un grid pattern sutil: líneas `rgba(15,23,42,0.035)` cada 60px.

### Componentes de UI adaptados a Blade

| Concepto original (React) | Implementación en Blade |
|---|---|
| **Light Gradient Background** | CSS mesh gradient con `radial-gradient` + grid pattern |
| **Text Reveal By Word** | Animación CSS `@keyframes fadeSlideUp` con `animation-delay` escalonado por palabra |
| **Bento Grid** | `grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6` con tarjetas independientes |
| **Interactive Hover Button** | Técnica CSS: `group-hover:translate-x-8` + icono que se desliza desde la izquierda |
| **Botón gradiente** | `bg-gradient-to-r from-blue-600 to-cyan-500` con sombra azulada en hover |
| **Progress Bar** | Barra con gradiente interno que cambia de color según el porcentaje |

---

## Estructura completa del proyecto

```
DB-Admin-FIS/
├── app/
│   ├── Console/Commands/
│   │   └── GenerateTestExcel.php               # Genera Excel de prueba
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   └── LoginController.php          # Login personalizado
│   │   │   ├── AdminDashboardController.php      # Dashboard + semáforo
│   │   │   ├── AdminElectivosController.php      # Placeholder
│   │   │   ├── AdminImportController.php         # Importación Excel (3 métodos)
│   │   │   ├── AdminReportesController.php       # Placeholder
│   │   │   ├── Controller.php
│   │   │   └── PublicController.php              # Quórum público
│   │   └── └──
│   ├── Imports/
│   │   ├── EstudiantesImport.php                 # ToModel + validación
│   │   ├── NotasHistoricasImport.php             # OnEachRow + transacción
│   │   └── SituacionAcademicaImport.php          # OnEachRow + CALL SP
│   ├── Models/
│   │   ├── Curso.php
│   │   ├── DetalleMatricula.php
│   │   ├── EstadoAcademico.php
│   │   ├── Estudiante.php
│   │   ├── Malla.php
│   │   ├── Matricula.php
│   │   ├── Periodo.php
│   │   ├── SituacionAcademica.php
│   │   └── User.php
│   └── Providers/
│       └── AppServiceProvider.php
│
├── bootstrap/
├── components/                                   # Componentes React (21st.dev)
│   └── ui/
│       ├── bento-grid.tsx
│       ├── interactive-hover-button.tsx
│       ├── light-gradient-background.tsx
│       └── text-reveal.tsx
│
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   │   ├── *create_initial_schema_from_raw_sql.php
│   │   ├── *create_triggers_and_procedures.php
│   │   └── *create_users_table.php
│   ├── seeders/
│   │   ├── AdminUserSeeder.php
│   │   └── DatabaseSeeder.php
│   └── sql/
│       ├── 00_create_database.sql
│       ├── 01_ddl.sql
│       ├── 02_dml.sql
│       └── 03_triggers_and_procedures.sql
│
├── public/
│   ├── images/
│   │   └── logo-fis.png                          # ⏳ Pendiente de colocar
│   └── ...
│
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│       ├── admin/
│       │   ├── dashboard.blade.php               # ✅ Semáforo + tabla
│       │   ├── electivos.blade.php                # ⏳ Placeholder
│       │   ├── importar.blade.php                 # ✅ 3 uploads Excel
│       │   └── reportes.blade.php                 # ⏳ Placeholder
│       ├── auth/
│       │   └── login.blade.php                    # ✅ Login
│       ├── components/
│       │   └── admin/
│       │       ├── navbar.blade.php
│       │       └── sidebar.blade.php
│       ├── layouts/
│       │   ├── admin.blade.php                    # ✅ Sidebar + navbar
│       │   └── public.blade.php
│       └── public/
│           └── quorum.blade.php                   # ✅ Bento grid
│
├── routes/
│   ├── console.php
│   └── web.php                                    # 10 rutas
│
├── storage/
│   └── app/test_import/                           # Excel de prueba
│       ├── test_estudiantes.xlsx
│       ├── test_notas_historicas.xlsx
│       └── test_situacion_academica.xlsx
│
├── .env.example
├── composer.json
├── package.json
└── vite.config.js
```

**Leyenda:** ✅ Implementado | ⏳ Placeholder/Pendiente | ❌ No existe

---

## Instalación

```bash
# 1. Clonar el repositorio
git clone <repo-url>
cd DB-Admin-FIS

# 2. Instalar dependencias PHP
composer install

# 3. Configurar variables de entorno
cp .env.example .env
# Editar .env:
#   DB_CONNECTION=mysql
#   DB_HOST=127.0.0.1
#   DB_PORT=3306
#   DB_DATABASE=BD_SeguimientoAcademico_FIS
#   DB_USERNAME=root
#   DB_PASSWORD=

# 4. Generar APP_KEY
php artisan key:generate

# 5. Ejecutar migraciones (crea BD, tablas, datos, trigger y SP)
php artisan migrate --force

# 6. Poblar datos iniciales (4 usuarios admin)
php artisan db:seed --force

# 7. Iniciar servidor
php artisan serve
```

Acceder a `http://localhost:8000/login` e iniciar sesión con cualquier usuario admin (`password`).

---

## Desarrollo

```bash
# Iniciar servidor + assets en paralelo
composer run dev

# Generar Excel de prueba
php artisan app:generate-test-excel

# Ver rutas
php artisan route:list

# Resetear BD completa
php artisan migrate:fresh --seed --force
```

---

## Testing

```bash
php artisan test
```

---

## Arquitectura Frontend

Actualmente el frontend usa **Tailwind CSS vía CDN** + **Alpine.js vía CDN** para las vistas Blade. Los componentes React en `components/ui/` están preparados para una futura integración con Vite + React.

### Vite config

```js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
```

---

## Estado del proyecto

| Aspecto | Estado |
|---|---|
| Base de datos + SQL | ✅ Completo (9 tablas, 2 triggers, 2 SP, 1 función, 1 vista) |
| Migraciones | ✅ Completas (4 migraciones) |
| Modelos Eloquent | ✅ 9 modelos con relaciones |
| Autenticación | ✅ Login personalizado + 4 usuarios admin |
| Layout admin | ✅ Sidebar, navbar, mesh gradient |
| Dashboard / Semáforo | ✅ Implementado con datos reales |
| Quórum público | ✅ Bento grid con progress bars |
| Importación Excel | ✅ 3 importadores probados |
| Módulo Electivos | ⏳ Placeholder |
| Módulo Reportes | ✅ Tabla de rezago desde `vw_EstudiantesRezago`. Pendiente: gráficos, exportación |
| CRUDs (cursos, mallas, estudiantes) | ❌ Pendiente |
| APIs REST | ❌ Pendiente |
| Logo institucional | ❌ Pendiente (colocar en `public/images/logo-fis.png`) |
| Tests automatizados | ❌ Pendiente |

---

## Créditos

Proyecto basado en el diseño de base de datos del Capítulo IV de la tesis:  
_"Diseño e implementación de una base de datos para el seguimiento de la situación académica de los estudiantes de la FIS - UNCP"_

### UI Components

Los componentes React en `components/ui/` están inspirados en componentes de [21st.dev](https://21st.dev) y [Magic UI](https://magicui.design), adaptados al design system corporativo claro de la aplicación.
