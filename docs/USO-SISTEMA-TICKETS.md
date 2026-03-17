# Guía de uso — Sistema de Tickets (TicketX)

Este documento explica cómo usar el sistema TicketX, su estructura modular y las tareas administrativas comunes. Está en español y listo para pegar en Google Docs.

---

## 1. Resumen

TicketX es un sistema de tickets de soporte basado en Laravel 5.2. Permite a usuarios crear tickets, agregar comentarios, y a administradores gestionar tickets, usuarios, roles, permisos, empresas y reportes.

Principales módulos:
- Autenticación y registro (social login incluido).
- Tickets (crear, ver, comentar, reabrir).
- Panel de administración (gestión de usuarios, roles, permisos, empresas, tickets).
- Notificaciones por correo (envío en background mediante `artisan` y jobs).
- Adjuntos / editor WYSIWYG (Summernote) con subida de imágenes.
- Reportes exportables (Excel / PDF).

---

## 2. Instalación (resumen)

Basado en `README-SETUP.md` del repositorio:

Requisitos principales:
- PHP 7.4
- MySQL
- Composer

Pasos clave:
1. Clonar el repositorio y entrar en la carpeta.
2. Copiar `.env.example` a `.env` y configurar la base de datos y mail.
3. Ejecutar `composer install`.
4. Generar la clave: `php7.4 artisan key:generate`.
5. Migrar y seed: `php7.4 artisan migrate --seed`.
6. Ajustar permisos: `chmod -R 777 storage bootstrap/cache`.
7. Iniciar servidor: `php7.4 artisan serve`.

Variables importantes en `.env`:
- `DB_*` (conexión a base de datos)
- `MAIL_DRIVER`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_FROM_ADDRESS`, `MAIL_FROM_NAME` (envío de correos)
- `SUPPORT_TEAM_EMAILS` — lista separada por comas con los correos del equipo de soporte (usada para notificar al equipo cuando se crea un ticket)

---

## 3. Autenticación y cuentas

Rutas principales:
- `/login` — inicio de sesión.
- `/signup` — registro de usuario.
- `/logout` — cerrar sesión.
- `/password/reset` — recuperación de contraseña.

Perfil y configuración de cuenta (rutas protegidas por `auth`):
- `/account` — panel de la cuenta.
- `/account/profile` — actualizar perfil (POST).
- `/account/photo` — cambiar avatar (POST).
- `/account/password` — cambiar contraseña (POST).
- `/account/delete` — opciones de borrado de cuenta.

El proyecto usa `Entrust` para roles y permisos.

---

## 4. Módulo de Tickets (usuario)

Acciones principales:
- Ver lista de mis tickets: `GET /tickets` (ruta nombrada `tickets.index`).
- Crear ticket: `GET /tickets/create` -> formulario, y `POST /tickets/store` para guardar.
  - Campos: `title`, `priority`, `message`, `category` (si aplica), `company` (si el usuario pertenece a varias empresas).
- Ver ticket: `GET /tickets/{ticket_id}` (ruta `tickets.show`).
- Reabrir ticket: `POST /reopen/{ticket_id}`.
- Comentar en ticket: `POST /comment` (usa `CommentController@postComment`).

Notas importantes:
- Cuando se crea un ticket se genera un `ticket_id` alfanumérico y se lanza un proceso para enviar correos (comando `send:ticket-email` en background).
- Upload de imágenes desde Summernote: `POST /summernote/upload` (protegida por `auth`). Responde con JSON `{link: <url>}`.

Modelos relevantes:
- `App\Ticket`: campos rellenables (`user_id`, `category_id`, `ticket_id`, `title`, `priority_id`, `message`, `status_id`, `technical_staff_id`, `company_id`, `work_time`). Relaciones con `User`, `Category`, `Priority`, `Status`, `Comment`, `TechnicalStaff`, `Company`.
- `App\Comment`: `ticket_id`, `user_id`, `comment`.

---

## 5. Panel de administración

Prefijo `/admin` con middleware de permisos (ej.: `permission:manage-tickets`, `permission:manage-users`, etc.).

Acciones disponibles (algunas rutas):
- Dashboard admin: `GET /admin` (`admin.dashboard`).
- Gestión de usuarios: `GET /admin/users`, `GET /admin/users/create`, `PATCH /admin/users/{id}`, `DELETE /admin/users/{id}` (restringido por `manage-users`).
- Roles y permisos: CRUD en `/admin/roles` y `/admin/permissions` (restringido por `manage-roles` / `manage-permissions`).
- Empresas: `/admin/companies` (crear/editar/borrar) (restringido por `manage-users`).
- Tickets administrativos: `/admin/tickets` y filtros (`open`, `closed`, `inprogress`, `reopened`), ver/editar/actualizar/Eliminar (`AdminTicketController`).
- Comentarios como admin: `POST /admin/tickets/comment`.
- Reportes exportables: `/admin/reports` y endpoints `reports/export-excel`, `reports/export-pdf`.

En el formulario de edición/actualización de ticket el admin puede cambiar categoría, prioridad, estado, asignar `technical_staff_id` y registrar `work_time` (horas y minutos).

---

## 6. Roles y permisos

El sistema utiliza `Zizaco\Entrust` para roles y permisos. Rutas y vistas usan middleware `permission:...` para controlar el acceso.

Permisos comunes en el código:
- `view-backend`
- `manage-users`
- `manage-roles`
- `manage-permissions`
- `manage-tickets`
- `manage-settings`

---

## 7. Soporte técnico (Technical Staff)

Modelo `App\TechnicalStaff` con campos `name`, `email`, `active`.
- Los técnicos activos pueden listarse para asignación en la vista admin (`AdminTicketController@show` utiliza `TechnicalStaff::where('active', true)`).
- Un técnico tiene relación `hasMany` con `Ticket`.

---

## 8. Correos y jobs

Flujo de correos:
- Al crear un ticket, el controlador `TicketsController@store` ejecuta en background:
  ```bash
  php7.4 artisan send:ticket-email {userId} {ticketId}
  ```
  (Se ejecuta con `exec(... &)` para no bloquear la petición HTTP.)
- `SendTicketEmail` (comando) y `SendTicketEmails` (Job) usan `App\Mailers\AppMailer` para armar y enviar plantillas de correo.
- `AppMailer` envía correos al propietario del ticket y al equipo de soporte (`SUPPORT_TEAM_EMAILS` en `.env`).

Recomendación: configurar un sistema de colas (Redis/Database) para procesar jobs de forma robusta. Actualmente, el proyecto lanza procesos en background directamente.

---

## 9. Archivos y vistas

Vistas principales se encuentran en `resources/views` (carpetas `tickets`, `admin/tickets`, `emails`, `auth`, etc.).
- Plantillas de correo: `resources/views/emails/*`.
- Formularios de tickets: `resources/views/tickets/*`.

---

## 10. Comandos útiles

- Iniciar servidor de desarrollo:
```bash
php7.4 artisan serve
```
- Generar clave de app:
```bash
php7.4 artisan key:generate
```
- Migrar y sembrar:
```bash
php7.4 artisan migrate --seed
```
- Enviar correo de ticket manualmente (útil para pruebas):
```bash
php7.4 artisan send:ticket-email <userId> <ticketId>
```

Si se configura la cola (queue) y jobs, usar:
```bash
php7.4 artisan queue:work
```

---

## 11. Flujo de uso (usuario)

1. Registrar cuenta o iniciar sesión.
2. Desde el panel de usuario (`/tickets`) crear un nuevo ticket (`/tickets/create`).
3. Completar título, prioridad, mensaje, categoría y empresa (si aplica).
4. Enviar: se recibirá confirmación por correo y el ticket aparecerá en la lista.
5. Abrir ticket y dejar comentarios; el propietario recibirá notificaciones de comentarios.

---

## 12. Flujo de uso (administrador)

1. Acceder a `/admin` (necesario `view-backend`).
2. Gestionar usuarios, roles y permisos según necesite.
3. Ir a `/admin/tickets` para ver tickets, filtrarlos por estado y asignarlos a técnicos.
4. Editar ticket para actualizar estado, prioridad, categoría y tiempo de trabajo; eso dispara notificaciones al propietario.
5. Exportar reportes desde `/admin/reports`.

---

## 13. Puntos técnicos y recomendaciones

- Laravel 5.2 y PHP 7.4: no actualizar PHP sin verificar compatibilidad de dependencias.
- Seguridad: revisar validaciones y sanitización en controladores (ya existen validaciones básicas en controladores principales).
- Emails: configurar correctamente `MAIL_*` en `.env` y `SUPPORT_TEAM_EMAILS` para notificaciones.
- Subidas: `public/uploads/summernote` usado para imágenes — ajustar permisos y revisar límites de tamaño y tipos permitidos.
- Tareas en background: actualmente se usan `exec(... &)` para llamar a `artisan` en background; migrar a colas con `queue:work` mejora robustez.

---

## 14. Mapeo rápido de archivos importantes

- Rutas: `app/Http/routes.php`
- Modelos: `app/Ticket.php`, `app/User.php`, `app/Comment.php`, `app/TechnicalStaff.php`, `app/Company.php`, `app/Category.php`, `app/Priority.php`, `app/Status.php`
- Controladores principales: `app/Http/Controllers/TicketsController.php`, `AdminTicketController.php`, `CommentController.php`, `UserController.php`, `SettingsController.php`, `AccountController.php`, `Auth/*`.
- Mailer y jobs: `app/Mailers/AppMailer.php`, `app/Jobs/SendTicketEmails.php`, `app/Console/Commands/SendTicketEmail.php`.
- Configuración mail: `config/mail.php`.

---

## 15. Próximos pasos (sugeridos)

- Revisar `resources/views` para capturar capturas de pantalla y ejemplos visuales para la documentación en Google Docs.
- Añadir ejemplos paso a paso con imágenes (pantallazos) para usuarios y admins.
- Convertir este archivo a un documento de Google Docs y ajustar estilos según la guía de la organización.

---

Si quieres, puedo:
- Generar una versión en formato Google Docs (texto plano + sugerencias de estructura).
- Añadir capturas automáticas de vistas (si quieres que abra vistas y genere screenshots).
- Incluir instrucciones detalladas para desplegar en producción (Nginx, Supervisor para colas, SSL, etc.).

Dime cuál de estas opciones prefieres y continúo con la siguiente tarea.
