# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

**Comedor OBU** (formerly "RiVerOBU") — a CodeIgniter 4 (PHP) web app for managing university cafeteria breakfast tickets ("comedor universitario"). Students log in and generate a digital ticket (with QR code) for the day's meal; admins manage students, meal plans ("platos del día"), attendance, incidents, and cash registers ("cajas"). All application code lives under `code/`, not the repo root.

## Commands

Run all commands from the `code/` directory.

```bash
composer install              # install PHP dependencies
php spark serve                # run the dev server (http://localhost:8080)
vendor/bin/phpunit              # run the full test suite (or: composer test)
vendor/bin/phpunit --filter TestName   # run a single test
vendor/bin/phpunit tests/unit/HealthTest.php   # run one test file
```

There is no JS/CSS build step — frontend assets (AdminLTE theme, Bootstrap, jQuery, DataTables, etc.) are vendored directly under `code/public/` and `code/AdminLTE/` and loaded from views via `base_url()`.

### Database

- Schema/data lives in `code/bdcomedor (5).sql` (a plain MySQL dump) — there are **no CI4 migrations or seeders** (`app/Database/Migrations` and `Seeds` are empty placeholders). To set up locally, import that SQL file directly.
- Configure the DB connection via `code/.env` (`database.default.*` keys) or `code/app/Config/Database.php`. The checked-in `.env` has everything commented out / using framework defaults — copy/edit it for a real local environment.
- Key tables: `students`, `usuarios` (admin/staff accounts), `tickets`, `tipo_comida`, `platos_del_dia`, `asistencias`, `incidencias`, `actividad_estudiantes`, `configuracion`, `logs_ingreso`.

## Architecture

Standard CodeIgniter 4 MVC layout under `code/app/`:

- **`Controllers/`** — one controller per feature area (`Estudiantes`, `Platos`, `Tickets`, `Asistencias`, `Incidencias`, `Actividades`, `Reportes`, `Cajas`, `Configuracion`, plus student-facing `TicketEstudiante` and `EstudiantePerfil`). `Auth.php` handles login for **both** roles (see below).
- **`Models/`** — mostly thin wrappers around CI4's Query Builder (`$table`/`$allowedFields` + a few custom finder methods like `TicketModel::verificarDisponibilidad()` / `contarTicketsEmitidos()`). Some raw joins are done ad hoc in controllers rather than models — check the existing pattern in the relevant controller before adding new queries.
- **`Views/`** — organized by feature folder (`tickets/`, `estudiantes/`, `asistencias/`, etc.), plus a shared `layout/` (`header.php`, `aside.php` for students, `aside_admin.php` for admins, `footer.php`) that admin/staff pages `echo` together manually (no CI4 layout/extend system in use — see `Tickets::index()` for the pattern: `echo view('layout/header'); echo view('layout/aside_admin'); ...`).
- **`Filters/AuthFilter.php`** — session-based auth guard (checks `session()->get('isLoggedIn')`), aliased as `'auth'` in `Config/Filters.php` and applied to a route group in `Config/Routes.php`. It does not distinguish between student and admin roles — that's done inside individual controllers/views via `session()->get('perfil')`.
- **`Libraries/Pdflibrary.php`** — thin subclass wrapping the vendored **TCPDF** library (`app/ThirdParty/tcpdf/`) used to render ticket PDFs with an embedded QR code (`TicketEstudiante::pdf()`).

### Auth model

There is no dedicated `users` abstraction shared between roles — `Auth::SesionLogin()` checks the posted `university_code`/`dni` against **two separate tables/models**: `LoginModels` (students) first, then `AdminModel` (`usuarios` table, staff/admin). Whichever matches sets session data and redirects accordingly (`cajas` for students, `caja_admin` for admins). Session keys to know: `isLoggedIn`, `id_estudiante` (students only), `id`, `perfil`, `university_code`, `full_name`, `is_scholarship`.

### Routing

`app/Config/Routes.php` combines CI4 auto-routing (`setAutoRoute(true)`) with explicit routes. Authenticated routes live inside a `$routes->group('', ['filter' => 'auth'], ...)` block. Note there are duplicate route definitions for `TicketEstudiante` both inside and outside the auth group — check both when tracing ticket routes.

### Third-party/vendored code — do not treat as project source

- `code/system/` — the CodeIgniter 4 framework itself (vendored, not installed via Composer in the usual `vendor/` sense — `composer.json`'s autoload maps `CodeIgniter\` to `system/`).
- `code/app/ThirdParty/tcpdf/` — vendored TCPDF library used for PDF ticket generation.
- `code/AdminLTE/` and `code/public/bower_components/` — vendored AdminLTE/Bootstrap/jQuery frontend theme (old Bower-based AdminLTE 2.x), referenced from views via `base_url()`.

When searching the codebase, scope searches to `code/app/` (and `code/tests/`) to avoid wading through vendored framework/theme code.

## Auditorías

**Política**: toda auditoría (seguridad, código, arquitectura) que se realice sobre este proyecto debe registrarse en esta sección, con fecha, alcance y hallazgos. No borrar auditorías anteriores; agregar nuevas entradas al final. Si un hallazgo se corrige, anotarlo como resuelto en la entrada original en vez de eliminarlo.

### 2026-07-15 — Auditoría de seguridad inicial (código propio en `app/`)

Alcance: `code/app/` (controladores, modelos, filtros, config, vistas). No se auditó el framework vendored (`system/`), TCPDF ni AdminLTE/bootstrap.

1. **[Alta] Autenticación usando el DNI como contraseña, en texto plano.**
   `Auth::SesionLogin()` (`app/Controllers/Auth.php:31-77`) compara el `dni` recibido por POST directamente contra la columna `dni` de `students`/`usuarios`, sin hashear. No existe `password_hash`/`password_verify` en ningún archivo del proyecto. El DNI es un identificador semi-público de 8 dígitos: cualquiera que conozca código universitario + DNI de una persona puede iniciar sesión como ella.
   *Recomendación*: usar una contraseña real, almacenada con `password_hash()` y verificada con `password_verify()`.

2. **[Alta] Sin protección CSRF.**
   `app/Config/Filters.php:31-36` tiene el filtro `csrf` comentado en `$globals['before']`, y no se aplica a ninguna ruta específica en `Config/Routes.php`. Todos los formularios POST (login, registrar ticket, alta/edición/baja de estudiantes, actualizar perfil) son vulnerables a CSRF.
   *Recomendación*: habilitar `csrf` en `$globals['before']` (o por ruta) y agregar `<?= csrf_field() ?>` a los formularios.

3. **[Alta] IDOR en descarga de PDF de ticket.**
   `TicketEstudiante::pdf($id)` (`app/Controllers/TicketEstudiante.php:106-168`) busca el ticket solo por `$id` numérico de la URL, sin filtrar por `session('id_estudiante')`. Cualquier estudiante autenticado puede enumerar `/ticket/pdf/{id}` y descargar el ticket (nombre completo, código universitario, condición de becado) de otro estudiante.
   *Recomendación*: agregar `->where('student_id', session('id_estudiante'))`, o permitir el bypass solo si `session('perfil') === 'Admin'`.

4. **[Media-Alta → confirmado Crítico el 2026-07-16, ver abajo] Falta de control de acceso por rol en controladores admin.**
   `AuthFilter` (`app/Filters/AuthFilter.php`) solo verifica `isLoggedIn`, nunca `perfil`. Controladores administrativos como `Estudiantes`, `Platos`, `Tickets`, `Asistencias`, `Incidencias`, `Cajas`, `Configuracion` y `Reportes` no comprueban `session('perfil') === 'Admin'` antes de ejecutar altas/ediciones/bajas (p. ej. `Estudiantes::eliminar`, `Tickets::eliminar`). Falta confirmar en runtime si el auto-routing de CI4 deja esas acciones dentro del grupo protegido por `'auth'`, pero incluso si el enrutamiento las cubre, no hay una segunda capa de autorización por rol.
   *Recomendación*: chequeo explícito de rol en cada controlador admin, o un filtro dedicado (`role:admin`).
   *Actualización 2026-07-16*: se confirmó con `php spark routes` que el problema era peor de lo descrito — el filtro `'auth'` del grupo en `Routes.php` solo cubre la ruta explícita `GET estudiantes`, no las acciones auto-enrutadas (`estudiantes/insertar`, `estudiantes/editar`, `estudiantes/eliminar`, etc.), que no tenían **ningún** filtro. Cualquier visitante sin sesión podía crear/editar/eliminar estudiantes por URL directa. Ver entrada de correcciones más abajo.

5. **[Media] HTML sin escapar al generar el PDF del ticket.**
   `TicketEstudiante::pdf()` concatena directamente `$ticket['full_name']` y `$ticket['university_code']` en el HTML pasado a TCPDF (`app/Controllers/TicketEstudiante.php:154-163`) sin `esc()`. Como `full_name` es editable por el propio estudiante vía `EstudiantePerfil::actualizar` (`app/Controllers/EstudiantePerfil.php:23-36`, tampoco sanitiza), esto permite inyección de HTML/CSS en el PDF generado a partir de datos que el propio usuario controla.
   *Recomendación*: aplicar `esc()` a todo valor interpolado antes de pasarlo a `writeHTML()`.

6. **[Media] `.env` versionado en git, sin `.gitignore`.**
   `code/.env` está trackeado desde el primer commit (`f3a444d`) y no existe ningún `.gitignore` en todo el repositorio. Hoy solo contiene la plantilla por defecto, pero cualquier credencial real (BD, `encryption.key`) que se cargue ahí quedará en el historial de git.
   *Recomendación*: agregar `.gitignore` (excluyendo `.env`, `writable/logs`, `writable/session`, `writable/cache`), sacar `.env` del tracking (`git rm --cached code/.env`) y distribuir un `.env.example`.

7. **[Baja] Credenciales de prueba en comentarios del código.**
   `app/Controllers/Auth.php:8-14` incluye en comentarios el código universitario y DNI de una cuenta admin y una de estudiante de prueba. Si corresponden a datos reales, es una fuga de información versionada.
   *Recomendación*: eliminar el comentario o reemplazarlo por datos claramente ficticios.

8. **[Baja] Sin regeneración de sesión en login.**
   `Auth::SesionLogin()` no llama a `session()->regenerate()` al autenticar, dejando una ventana teórica de session fixation.
   *Recomendación*: invocar `session()->regenerate(true)` justo antes de `session()->set(...)`.

### 2026-07-16 — Correcciones aplicadas sobre la auditoría del 2026-07-15

A pedido del usuario se corrigieron 7 de los 8 hallazgos. El hallazgo #1 (login con código universitario + DNI como contraseña) se mantiene **intencionalmente** tal cual — el usuario confirmó que así es como se inicia sesión hoy en ambos roles (estudiante y administrador/`usuarios`), y cambiar el esquema de autenticación (agregar contraseñas reales) requeriría decidir credenciales nuevas y migrar datos, algo que no se hizo sin instrucción explícita. La columna `password` ya existe en `students` y `usuarios` (con hashes bcrypt de relleno, no utilizables) — quedó sin usar; si en el futuro se decide migrar a contraseñas reales, esa columna es el punto de partida.

1. **Hallazgo #2 (CSRF) — resuelto.** Filtro `csrf` habilitado globalmente en `app/Config/Filters.php`. Se agregó `<?= csrf_field() ?>` a los 16 formularios POST del proyecto (login, perfil, y los formularios de alta/edición de estudiantes, tickets, platos, incidencias, actividades, asistencias, configuración y clientes). El único POST que no era un `<form>` (el AJAX de `TicketEstudiante/registrar` en `tickets/hoy.php`) ahora envía el token vía `data: { "<?= csrf_token() ?>": "<?= csrf_hash() ?>" }`. Verificado sirviendo la app localmente: el campo oculto se renderiza con un token real.

2. **Hallazgo #3 (IDOR en PDF) y #5 (HTML sin escapar en PDF) — resueltos.** `TicketEstudiante::pdf()` (`app/Controllers/TicketEstudiante.php`) ahora filtra por `tickets.student_id = session('id_estudiante')` salvo que `session('perfil') === 'Administrador'`. Los valores `full_name` y `university_code` se pasan por `esc()` antes de concatenarse al HTML de TCPDF.

3. **Hallazgo #4 (control de acceso por rol) — resuelto, y ampliado.** Al investigar se confirmó con `php spark routes` que el filtro de ruta por grupo en `Routes.php` **no cubre las acciones auto-enrutadas** (bug de framework/config, no solo falta de chequeo de rol). La corrección real se hizo en `app/Config/Filters.php`, aplicando `auth` y un nuevo filtro `adminOnly` (`app/Filters/AdminOnlyFilter.php`, compara `session('perfil') === 'Administrador'`) como filtros **globales** con patrones `except` basados en la URI real de la petición (mecanismo `$globals['before']['alias'] => ['except' => [...]]` de CI4), en vez de depender del filtro por grupo de rutas. Esto protege automáticamente cualquier controlador/acción presente o futuro, incluidas las auto-enrutadas, sin tener que enumerar cada ruta admin a mano. Rutas públicas: `/`, `auth*`. Rutas de solo-estudiante (requieren login pero no rol admin): `perfil*`, `ticket/*`, `ticketestudiante*`. Todo lo demás requiere `perfil === 'Administrador'`. Verificado en vivo contra el servidor de desarrollo: `estudiantes/insertar` sin sesión ahora responde 302 (antes: 200, sin protección alguna).

4. **Hallazgo #6 (`.env` y datos versionados en git) — resuelto parcialmente, requiere decisión pendiente.** Se agregó `.gitignore` en la raíz de `SistemaTicketsOBU/` (no en la raíz del monorepo, para no afectar otros proyectos como BiciMundo) excluyendo `code/.env` y el contenido de `code/writable/{cache,debugbar,logs,session,uploads}`. Se hizo `git rm --cached` de `code/.env`, de ~190 archivos de sesión en `code/writable/session/` y de 19 volcados JSON del debugbar en `code/writable/debugbar/` — todos quedaron sin trackear (siguen en el disco local, no se borró nada). Se creó `code/.env.example` como plantilla para nuevos entornos. **Pendiente de decisión del usuario**: estos archivos ya estaban en el historial de git y ya se habían empujado a `origin/master`, así que siguen siendo recuperables desde commits anteriores. Purgarlos del historial requeriría reescribirlo (`git filter-repo` o BFG) y luego un force-push — una operación destructiva que no se ejecutó sin autorización explícita.

5. **Hallazgo #7 (credenciales de prueba en comentarios) — resuelto.** Se eliminó el bloque de comentarios con código universitario/DNI de admin y estudiante en `app/Controllers/Auth.php`.

6. **Hallazgo #8 (sin regeneración de sesión) — resuelto.** Se agregó `session()->regenerate(true)` justo antes de `session()->set(...)` en ambas ramas (estudiante y administrador) de `Auth::SesionLogin()`.

7. **Rebranding.** Por pedido del usuario, el nombre del proyecto pasó de "RiVerOBU" a "**Comedor OBU**" en `README.md`, `admin/login.php`, `layout/header.php`, `layout/footer.php` y el título del PDF generado en `TicketEstudiante::pdf()`.
