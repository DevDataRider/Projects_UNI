# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

**Comedor OBU** (formerly "RiVerOBU") — a CodeIgniter 4 (PHP) web app for managing university cafeteria meal tickets ("comedor universitario"). Three service turnos run Monday–Friday only, defined in one place (`App\Libraries\HorarioComedor`): desayuno 7:00–9:30, almuerzo 12:00–14:00, cena 17:00–19:00 (`tipo_comida_id` 1/2/3). Students log in and generate a digital ticket with a QR code for whichever turno is currently active (registration and the student dashboard both refuse outside those windows/days); cafeteria staff scan that QR (`verificar_ticket/{id}`, admin-only) to see the student's order number, full name, faculty ("facultad") and turno, and confirm delivery, which marks the ticket used and logs an `asistencias` row. Admins also manage students, meal plans ("platos del día", now selectable by turno), attendance, incidents, and cash registers ("cajas"). All application code lives under `code/`, not the repo root.

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

## Registro de cambios (funcionalidades y correcciones)

**Política**: igual que en Auditorías — no borrar entradas anteriores, agregar nuevas al final. Esta sección registra trabajo de producto/UX y bugs corregidos que no son hallazgos de seguridad (esos van en Auditorías).

### 2026-07-20 — Flujo de tickets por turno, UI de Inicio, tipografía y varios bugs

1. **Bug de zona horaria en `HorarioComedor` (raíz: `App\Config\App::$appTimezone`).** CodeIgniter fija `date_default_timezone_set()` al valor de `$appTimezone` en cada request, que estaba en `'UTC'`. Como `HorarioComedor::turnoActual()` corre en el controlador antes de que ninguna vista alcance a hacer su propio `date_default_timezone_set('America/Lima')`, comparaba la hora en UTC: a las 7:27 a.m. hora Lima (UTC-5) son las 12:27 UTC, que cae dentro del rango de Almuerzo. Por eso el dashboard mostraba "Almuerzo" y el ticket se generaba con el tipo de comida equivocado a esa hora. **Corregido** cambiando `$appTimezone` a `'America/Lima'` (`app/Config/App.php`) — arregla el problema para toda la app, no solo para esa pantalla.

2. **`TicketEstudiante::pdf()` servía el PDF con `Content-Type: text/html`.** El método hacía `echo`/`Output(..., 'D')` directo de TCPDF sin devolver un `Response` de CI4; como el controlador no retornaba nada, CodeIgniter mandaba igual su propia respuesta después, y sus headers por defecto pisaban los que TCPDF ya había puesto (`Content-Type` y `Cache-Control` quedaban duplicados/incorrectos). El archivo en sí era un PDF válido, pero el navegador no lo reconocía como tal al abrirlo. **Corregido**: ahora genera el PDF con `Output(..., 'S')` (como string) y lo devuelve explícitamente vía `$this->response->setHeader(...)->setBody(...)`. De paso, el nombre del archivo pasó de `ticket_{id}.pdf` a `Ticket_{nro_orden}_{Becado|No}_{codigo}_{nombre}.pdf` (nombre transliterado sin tildes/ñ para que sea válido como nombre de archivo en cualquier SO).

3. **Filtro `adminOnly` bloqueaba `/cajas` (Inicio del estudiante).** El `except` de `adminOnly` en `app/Config/Filters.php` no incluía `cajas*`, así que cualquier estudiante que entraba a "Inicio" era redirigido en silencio a `ticket/hoy` — nunca llegaba a ver el dashboard real. Esto hacía que "Inicio" y "Mi Ticket de Hoy" parecieran mostrar lo mismo. **Corregido** agregando `'cajas*'` al `except` de `adminOnly`.

4. **Rediseño de responsabilidades entre "Inicio" y "Mi Ticket de Hoy" (rol estudiante).**
   - `Cajas::index()` / `inicio/cajas.php` ("Inicio") es ahora **solo de lectura**: 3 tarjetas (Estudiante, Plato del Día, Tu Ticket) que muestran el estado actual; la tarjeta "Tu Ticket" solo dice Disponible/No disponible + link de descarga si ya existe, **sin** botón para generar.
   - `TicketEstudiante::hoy()` / `tickets/hoy.php` ("Mi Ticket de Hoy") es el **único lugar** donde se puede reservar el ticket del turno activo. Al generar, se muestra un modal de confirmación con nombre, código, fecha, tipo de comida, número de orden y QR (solo se cierra con el botón "Listo", `data-backdrop="static"` + `data-keyboard="false"`); al cerrarlo, la página se recarga (`location.reload()`) y ya se ve el estado "Ticket Registrado" con el link "Ver Ticket PDF".
   - `TicketEstudiante::registrar()` ahora también devuelve `ticket_id` en el JSON (antes solo lo usaba para armar la URL del QR internamente).
   - Un turno solo permite un ticket por estudiante por día (ya existía vía `TicketModel::verificarDisponibilidad()`), así que el mismo flujo aplica igual para desayuno, almuerzo y cena.

5. **`PlatoModel::obtenerPlatoDelDia(fecha, tipoComidaId)` (nuevo método).** Antes, si no había un plato cargado para la fecha exacta, la tarjeta "Plato del Día" quedaba vacía ("Aún no se cargó el menú..."). Ahora, si no hay un plato exacto: **desayuno** rota entre 4 menús fijos (`Pan con queso, pan con palta, cuaquer y mandarina`; `Pan con mermelada, pan con torreja, cafe con leche y 1 huevo sancochado`; `Pan con lomo, pan con jamonada, soya y galleta rellenitas`; `Pan integral con palta, pan con tortilla, emoliente y queque`) según el día de la semana; **almuerzo** rota entre los almuerzos que ya existen en la tabla `platos_del_dia`; **cena** reutiliza el almuerzo resuelto para ese mismo día (no hay menú de cena propio todavía). `Cajas::index()` usa este método en vez de un `where()` directo por fecha exacta.

6. **Columna "Hora" agregada a las tablas de tickets.** Tanto `tickets/historial.php` (estudiante, "Historial de Consumo") como `tickets/listatickets.php` (admin, nav "Tickets") ahora muestran la hora de generación usando la columna `tickets.created_at` que ya existía pero no se mostraba en ninguna vista — no hizo falta ninguna migración. De paso, en `historial.php` el formato de fecha pasó de `d/m/Y` a `d-m-Y`.

7. **Manejo de error CSRF sin stack trace crudo.** `app/Config/Security.php` tenía `$redirect = false`; combinado con `CI_ENVIRONMENT=development`, cualquier mismatch de token CSRF (p. ej. al borrar cookies del navegador y reintentar login) mostraba la excepción completa de PHP en pantalla en vez de una pantalla de error manejada. **Corregido**: `$redirect = true`, y `Auth::index()` ahora lee la flashdata `error` que deja el filtro CSRF al redirigir y la muestra como *"Tu sesión había expirado. Por favor, vuelve a intentarlo."*, con el mismo estilo visual que el error de credenciales incorrectas.

8. **Tipografía global.** Se cambió la fuente de Google Fonts de Poppins (importada pero sin usar) a **Lora** (serif, formal/académica), aplicada a `body`, sidebar, tarjetas y tablas vía `public/dist/css/custom.css`. Se definieron tamaños explícitos para `h1`–`h6` (más grandes que los defaults de Bootstrap 3, respetando la jerarquía). De paso se detectó que buena parte del markup de `inicio/cajas.php` usaba clases de utilidad de Bootstrap 4/5 (`p-4`, `mb-3`, `g-4`, `d-flex`, `fw-bold`, etc.) que **no existen en Bootstrap 3** (la versión que corre este proyecto) y por lo tanto no hacían nada — esa era la causa real de que el contenido de las tarjetas quedara pegado a los bordes. Se agregó CSS explícito (padding real, separación entre tarjetas apiladas en mobile, tamaños de avatar/ícono responsivos con media query a 767px) en vez de depender de esas clases muertas.

9. **`.sidebar-title` ("Menú Estudiante" / "Menú Principal") no se ocultaba al colapsar el sidebar.** Es un `<h4>` custom, no el `<li class="header">` nativo de AdminLTE, así que la lógica automática de colapso de AdminLTE no lo alcanzaba (sí ocultaba el logo y las etiquetas de los ítems del menú, que sí siguen el patrón nativo). Se agregó `body.sidebar-collapse .sidebar-title { display: none; }` en `custom.css`, que cubre ambos roles porque ese archivo es compartido.

10. **Año del footer** actualizado de 2025 a 2026 en `layout/footer.php` (compartido por ambos roles).

11. **`Tickets::eliminar()` (admin, nav "Tickets") tiraba una excepción cruda al borrar un ticket con asistencia registrada.** `asistencias.ticket_id` tiene una FK hacia `tickets.id` con `ON DELETE RESTRICT` (confirmado vía `information_schema.REFERENTIAL_CONSTRAINTS`); borrar un ticket que ya fue confirmado/entregado por el personal (es decir, que ya generó su fila en `asistencias`) hacía que MySQL rechazara el `DELETE`, y como no había `try/catch`, se propagaba como `DatabaseException` sin manejar — con `CI_ENVIRONMENT=development` eso se traduce en el stack trace completo mostrado al admin. **Corregido**: se envuelve el `delete()` en un `try/catch` y se redirige con un mensaje claro ("ya tiene una asistencia registrada"). También se detectó que `tickets/listatickets.php` no mostraba flashdata de ningún tipo (ni de este ni de ningún otro flujo), así que se agregó un bloque `alert-danger`/`alert-success` al inicio de la vista para que el mensaje sea visible. Reproducido y verificado con `curl` antes y después del fix (antes: HTTP 500 con el stack trace; después: 302 + mensaje visible, ticket intacto en ambos casos).

12. **Reportes (`app/Controllers/Reportes.php`) — Excel/PDF de Incidencias, Actividades y Asistencias rotos.**
    - `ExcelIncidencias`, `ExcelActividades` y `ExcelAsistencias` **no existían como métodos** aunque las vistas (`incidencias/listaincidencias.php`, `actividades/listaactividades.php`, `asistencias/listaasistencias.php`) ya tenían botones "Exportar Excel" apuntando a esas rutas — daban 404. Se agregaron los tres, siguiendo el mismo patrón que `ExcelEstudiantes` (tabla HTML con `utf8_decode`, headers `application/vnd.ms-excel`).
    - Los 4 métodos `PDF*()` (`PDFEstudiantes`, `PDFAsistencias`, `PDFIncidencias`, `PDFActividades`) tenían el mismo bug de `Content-Type: text/html` que `TicketEstudiante::pdf()` (ver punto 2) — mismo origen (`echo`/`Output('D')` sin devolver `Response`), misma corrección (`Output('S')` + `$this->response->setHeader(...)->setBody(...)`). Se agregó además `$pdf->SetTitle(...)` a los 4 (antes no tenían título de documento en el metadata, aunque sí un `<h3>` visual en la página — lo que el usuario percibía como "sin título" era la metadata, no el encabezado visual) y `align="center"` a las tablas para centrar el contenido en la página.
    - Los PDF de Incidencias y Actividades no entraban en el ancho de la página (columnas sumaban ~650 unidades vs. ~570 que sí caben) y se veían truncados. Se angostaron las columnas (~500 unidades totales, fuente más chica en las filas) y se separó la columna "Fecha" en **Fecha** y **Hora** (ambas tablas ya tenían columnas `datetime`/`timestamp` con hora incluida, solo hacía falta formatear con `date('d-m-Y', ...)` / `date('h:i A', ...)`).

13. **Orden "más reciente primero" y formato de fecha `dd-mm-yyyy` estandarizado en todo el sistema.** Se auditaron todos los listados con fecha (pantalla, PDF y Excel) y se corrigieron dos problemas:
    - **Orden**: `PlatoModel::obtenerPlatosConTipo()` ordenaba `fecha ASC` (más antiguo primero), así que un plato recién agregado quedaba al final de la lista/paginación en vez de aparecer arriba — este fue el bug reportado explícitamente por el usuario. `AsistenciasModel::obtenerAsistenciasConTickets()` ordenaba por `asistencias.id DESC`, que no siempre coincide con el orden cronológico real si se registran asistencias con fecha retroactiva. Ambos se cambiaron a ordenar `DESC` por la columna de fecha real (`fecha` / `fecha_ingreso`). Tickets, Incidencias, Actividades y el Historial del estudiante ya ordenaban `DESC` correctamente.
    - **Formato**: se estandarizó `dd-mm-yyyy` (agregando la hora cuando la columna es `datetime`/`timestamp`, para no perder esa información) en las vistas admin de Tickets, Incidencias, Actividades, Asistencias y Platos del Día, y en los exports Excel/PDF de Incidencias, Actividades y Asistencias.
