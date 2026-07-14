# DB-Admin-FIS

Plataforma de administración académica para el seguimiento de la situación académica de los estudiantes de la **Facultad de Ingeniería de Sistemas (FIS)** de la UNCP.

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

### Dependencias PHP (Composer)

| Paquete | Propósito |
|---|---|
| `laravel/framework` ^11.31 | Framework base |
| `laravel/tinker` ^2.9 | REPL interactivo |
| `laravel/sail` ^1.26 | Entorno Docker (dev) |
| `phpunit/phpunit` ^11.0 | Testing |

### Dependencias Frontend (npm)

| Paquete | Propósito |
|---|---|
| `tailwindcss` ^3.4.13 | Utility-first CSS |
| `vite` ^6.0.11 | Bundler |
| `laravel-vite-plugin` ^1.2.0 | Integración Laravel + Vite |
| `postcss` ^8.4.47 + `autoprefixer` ^10.4.20 | Procesado CSS |
| `axios` ^1.7.4 | HTTP client |
| `concurrently` ^9.0.1 | Ejecución paralela de procesos |
| `framer-motion` ^12.42.2 | Animaciones React |
| `lucide-react` ^1.24.0 | Iconos React |
| `clsx` ^2.1.1 | Condicionales de clases |
| `tailwind-merge` ^3.6.0 | Fusión inteligente de clases Tailwind |

---

## Base de Datos

**Motor:** MySQL 8.x
**Nombre:** `BD_SeguimientoAcademico_FIS`

### Esquema Entidad-Relación

```
malla ──┬── curso ──── prerrequisito (N:M reflexiva)
         │
         └── estudiante ──┬── situacion_academica ──── estado_academico
                          │
                          └── matricula ──── detalle_matricula ──── periodo
```

### Tablas

| Tabla | Propósito | Columnas clave |
|---|---|---|
| `malla` | Planes curriculares (Malla 2018-I, Malla 2023-I) | `id_malla`, `nombre`, `anio` |
| `curso` | Catálogo de asignaturas por malla | `cod_curso` (PK string), `nombre`, `ciclo`, `creditos`, `id_malla` (FK) |
| `prerrequisito` | Relación N:M reflexiva entre cursos | `cod_curso` (FK), `cod_prerrequisito` (FK) |
| `estudiante` | Padrón de estudiantes | `cod_estudiante` (PK string), `nombre`, `email`, `id_malla` (FK) |
| `estado_academico` | Catálogo de estados | `id_estado`, `descripcion` (Aprobado, Desaprobado, Pendiente, etc.) |
| `situacion_academica` | Estado de cada estudiante en cada curso (tabla puente) | `id_situacion`, `cod_estudiante` (FK), `cod_curso` (FK), `id_estado` (FK), `desea_llevar` |
| `periodo` | Periodos académicos | `id_periodo`, `nombre` (ej. 2026-I) |
| `matricula` | Matrícula de estudiantes por periodo | `id_matricula`, `cod_estudiante` (FK), `id_periodo` (FK) |
| `detalle_matricula` | Cursos matriculados por estudiante en un periodo | `id_detalle`, `id_matricula` (FK), `cod_curso` (FK) |

### Datos iniciales

- 2 mallas (2018-I y 2023-I)
- 118 cursos (60 de Malla 2018-I + 58 de Malla 2023-I)
- 54 prerrequisitos
- 5 estados académicos
- 15 estudiantes reales del padrón 2026-I
- 23 registros de situación académica de la encuesta 2026-I (4 estudiantes)
- 1 periodo (2026-I)

---

## Migraciones

El proyecto usa **SQL crudo** ejecutado con `DB::unprepared()` para preservar el esquema original (DDL de MySQL Workbench) sin reescribirlo con el Schema Builder de Laravel.

| Archivo | Contenido |
|---|---|
| `database/sql/00_create_database.sql` | `CREATE DATABASE IF NOT EXISTS` |
| `database/sql/01_ddl.sql` | DDL de las 9 tablas con FK, índices y CHECK |
| `database/sql/02_dml.sql` | Datos iniciales (INSERTs) |
| `database/migrations/*_create_initial_schema_from_raw_sql.php` | Migración que ejecuta los 3 SQL |

---

## Modelos Eloquent

| Modelo | Tabla | PK | Timestamps | Relaciones |
|---|---|---|---|---|
| `Malla` | malla | id_malla (int) | ❌ | hasMany `Curso`, hasMany `Estudiante` |
| `Curso` | curso | cod_curso (string) | ❌ | belongsTo `Malla`, belongsToMany `Curso` (prerrequisitos) |
| `Estudiante` | estudiante | cod_estudiante (string) | fecha_registro | belongsTo `Malla`, hasMany `SituacionAcademica`, hasMany `Matricula` |
| `EstadoAcademico` | estado_academico | id_estado (int) | ❌ | — |
| `SituacionAcademica` | situacion_academica | id_situacion (int) | fecha_registro | belongsTo `Estudiante`, `Curso`, `EstadoAcademico` |
| `Periodo` | periodo | id_periodo (int) | ❌ | — |
| `Matricula` | matricula | id_matricula (int) | fecha_matricula | belongsTo `Estudiante`, `Periodo`, hasMany `DetalleMatricula` |
| `DetalleMatricula` | detalle_matricula | id_detalle (int) | ❌ | belongsTo `Matricula`, `Curso` |
| `User` | users | id (int) | ✓ | Autenticación Laravel por defecto |

---

## Enrutamiento

### Rutas públicas

| Método | URI | Controlador | Descripción |
|---|---|---|---|
| GET | `/verano-quorum` | `PublicController@quorum` | Vista pública del quórum de verano |

### Rutas admin (prefijo `/admin`)

| Método | URI | Controlador | Descripción |
|---|---|---|---|
| GET | `/admin/dashboard` | `AdminDashboardController@index` | Semáforo de quórum de verano |
| GET | `/admin/electivos` | `AdminElectivosController@index` | Sondeo de cursos electivos |
| GET | `/admin/reportes` | `AdminReportesController@index` | Reportes de riesgo y rezago |
| GET | `/admin/importar` | `AdminImportController@index` | Importación de datos desde Excel |

> Nota: El middleware `auth` está comentado en `routes/web.php`. Todas las rutas son públicas actualmente.

---

## Controladores — Lógica de negocio

### AdminDashboardController / PublicController

Ambos ejecutan la misma consulta de quórum:

```php
DB::table('curso')
    ->join('situacion_academica', 'curso.cod_curso', '=', 'situacion_academica.cod_curso')
    ->where(fn($q) => $q->where('desea_llevar', 'Si')->orWhereIn('id_estado', [2, 4]))
    ->select('curso.cod_curso', 'curso.nombre', 'curso.ciclo',
             DB::raw('COUNT(situacion_academica.cod_estudiante) as total_interesados'))
    ->groupBy('curso.cod_curso', 'curso.nombre', 'curso.ciclo')
    ->orderByDesc('total_interesados')
    ->get();
```

Filtra estudiantes con `desea_llevar = 'Si'` o en estado Desaprobado (2) / Pendiente (4).

### AdminElectivosController, AdminReportesController, AdminImportController

Actualmente son placeholders que renderizan sus respectivas vistas sin lógica de negocio.

---

## Vistas — Interfaz de usuario

### Layouts

| Archivo | Descripción |
|---|---|
| `layouts/admin.blade.php` | Layout principal del panel admin. Sidebar blanco (`bg-white border-r border-slate-200`), navbar superior translúcido, main con fondo mesh gradient. Responsivo con menú móvil vía Alpine.js. |
| `layouts/public.blade.php` | Layout público centrado, sin sidebar (no usado actualmente por quorum.blade.php, que es standalone). |

### Vistas admin

| Ruta | Vista | Descripción | Componentes UI |
|---|---|---|---|
| `/admin/dashboard` | `admin.dashboard` | Tabla con semáforo de colores, badges de quórum por curso e Interactive Hover Button en acciones. | Tabla Data-Dense, Badges semáforo, Interactive Hover Button |
| `/admin/electivos` | `admin.electivos` | Placeholder | — |
| `/admin/reportes` | `admin.reportes` | Placeholder | — |
| `/admin/importar` | `admin.importar` | Placeholder | — |

### Vistas públicas

| Ruta | Vista | Descripción | Componentes UI |
|---|---|---|---|
| `/verano-quorum` | `public.quorum` | Bento Grid de tarjetas con barra de progreso por curso. | Light Gradient Background, Text Reveal, Bento Grid, Progress Bar |

### Componentes reutilizables

| Archivo | Descripción |
|---|---|
| `components/admin/sidebar.blade.php` | Menú vertical con iconos SVG inline, active state azul. |
| `components/admin/navbar.blade.php` | Barra superior con botón hamburguesa (móvil), título dinámico y avatar. |

### Componentes React (21st.dev)

> Ruta: `resources/js/components/ui/` (futura integración con Vite + React)

| Archivo | Descripción |
|---|---|
| `bento-grid.tsx` | Cuadrícula asimétrica de tarjetas con `BentoGrid`, `BentoCard`, `BentoTitle`, `BentoDescription`, `BentoContent` y `BentoGridWithFeatures`. |
| `text-reveal.tsx` | Componente `TextRevealByWord` que revela palabras una por una al hacer scroll, usando `framer-motion` + `useScroll`. |
| `interactive-hover-button.tsx` | Botón interactivo con estados idle → loading → success, animaciones con `framer-motion` y `lucide-react`. Anima círculo expansivo, texto deslizante y spinners. |
| `light-gradient-background.tsx` | Fondo mesh gradient claro con patrones geométricos y diagonales. Adaptado a tema corporativo claro. |

---

## Semáforo de Quórum

| Interesados | Badge | Clase Tailwind | Color barra (progreso) |
|---|---|---|---|
| ≥ 8 | Cumple Quórum | `bg-green-100 text-green-800` / `bg-blue-500` | Verde/Azul |
| 5-7 | Por alcanzar | `bg-yellow-100 text-yellow-800` / `bg-yellow-500` | Amarillo |
| < 5 | Demanda baja | `bg-red-100 text-red-800` / `bg-red-400` | Rojo |

La meta es **8 estudiantes** para abrir un curso de verano.

---

## Diseño UI/UX

### Design System: Soft UI Evolution (Light Mode)

| Token | Valor |
|---|---|
| Fondo general | `bg-slate-50` / mesh gradient |
| Tarjetas | `bg-white`, `border-slate-100`, `shadow-sm hover:shadow-md` |
| Títulos | `text-slate-900 font-semibold` |
| Texto secundario | `text-slate-500` / `text-slate-400` |
| Bordes | `border-slate-200` / `border-slate-100` |
| Sidebar activo | `bg-blue-50 text-blue-700` |
| Transiciones | `transition-all duration-300` |

### Componentes de UI adaptados a Blade

| Concepto original | Implementación en Blade |
|---|---|
| **Light Gradient Background** | CSS mesh gradient con `radial-gradient` + patrones geométricos `rgba(15,23,42,0.035)` |
| **Text Reveal** | Animación CSS `@keyframes fadeSlideUp` por palabra con `animation-delay` escalonado |
| **Bento Grid** | `grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6` con tarjetas independientes |
| **Interactive Hover Button** | Técnica `group-hover:translate-x-8 group-hover:opacity-0` + icono que se desliza |

---

## Estructura completa del proyecto

```
DB-Admin-FIS/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── AdminDashboardController.php
│   │       ├── AdminElectivosController.php
│   │       ├── AdminImportController.php
│   │       ├── AdminReportesController.php
│   │       ├── Controller.php
│   │       └── PublicController.php
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
├── components/                         # Componentes React (21st.dev)
│   └── ui/
│       ├── bento-grid.tsx
│       ├── interactive-hover-button.tsx
│       ├── light-gradient-background.tsx
│       └── text-reveal.tsx
│
├── config/
│   ├── app.php
│   ├── auth.php
│   ├── cache.php
│   ├── database.php
│   ├── filesystems.php
│   ├── logging.php
│   ├── mail.php
│   ├── queue.php
│   ├── services.php
│   └── session.php
│
├── database/
│   ├── factories/
│   │   └── UserFactory.php
│   ├── migrations/
│   │   └── 2026_07_14_013217_create_initial_schema_from_raw_sql.php
│   ├── seeders/
│   │   └── DatabaseSeeder.php
│   └── sql/
│       ├── 00_create_database.sql
│       ├── 01_ddl.sql
│       └── 02_dml.sql
│
├── resources/
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   ├── app.js
│   │   └── bootstrap.js
│   └── views/
│       ├── admin/
│       │   ├── dashboard.blade.php
│       │   ├── electivos.blade.php
│       │   ├── importar.blade.php
│       │   └── reportes.blade.php
│       ├── components/
│       │   └── admin/
│       │       ├── navbar.blade.php
│       │       └── sidebar.blade.php
│       ├── layouts/
│       │   ├── admin.blade.php
│       │   └── public.blade.php
│       ├── public/
│       │   └── quorum.blade.php
│       └── welcome.blade.php
│
├── routes/
│   ├── console.php
│   └── web.php
│
├── .env.example
├── artisan
├── composer.json
├── composer.lock
├── package.json
├── postcss.config.js
├── tailwind.config.js
└── vite.config.js
```

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
# Editar .env con credenciales de MySQL:
#   DB_CONNECTION=mysql
#   DB_HOST=127.0.0.1
#   DB_PORT=3306
#   DB_DATABASE=BD_SeguimientoAcademico_FIS
#   DB_USERNAME=root
#   DB_PASSWORD=

# 4. Generar APP_KEY
php artisan key:generate

# 5. Ejecutar migraciones (crea BD, tablas y carga datos)
php artisan migrate --force

# 6. Iniciar servidor de desarrollo
php artisan serve

# 7. (Opcional) Compilar assets frontend
npm install
npm run dev
```

---

## Desarrollo

```bash
# Iniciar servidor Laravel + assets en paralelo
composer run dev
# o manualmente:
php artisan serve
npm run dev
```

### Comandos útiles

```bash
# Ver todas las rutas
php artisan route:list

# Ver el estado de las migraciones
php artisan migrate:status

# Resetear base de datos y volver a migrar
php artisan migrate:fresh --force
```

---

## Testing

```bash
php artisan test
# o
./vendor/bin/phpunit
```

---

## Arquitectura Frontend

Actualmente el frontend usa **Tailwind CSS via CDN** + **Alpine.js via CDN** para las vistas Blade. Los componentes React en `components/ui/` están preparados para una futura integración con Vite + React dentro del ecosistema Laravel.

### Vite config

```js
// vite.config.js
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

## Créditos

Proyecto basado en el diseño de base de datos del Capítulo IV de la tesis:  
_"Diseño e implementación de una base de datos para el seguimiento de la situación académica de los estudiantes de la FIS - UNCP"_

### UI Components

Los componentes React en `components/ui/` están inspirados en componentes de [21st.dev](https://21st.dev) y [Magic UI](https://magicui.design), adaptados al design system corporativo claro de la aplicación.

- **Bento Grid** — Layout asimétrico de tarjetas
- **Text Reveal By Word** — Animación de revelado de texto por scroll/load
- **Interactive Hover Button** — Botón con estados idle → loading → success
- **Light Gradient Background** — Fondo mesh gradient claro con patrones sutiles
