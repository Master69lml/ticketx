# Guía de Configuración de TicketX

Esta guía contiene las instrucciones paso a paso para configurar y ejecutar el proyecto TicketX, un sistema de tickets de soporte basado en Laravel 5.2.

## Requisitos Previos

- PHP 7.4 (Requerido: Laravel 5.2 no es compatible con PHP 8.x)
- MySQL 5.7 o superior
- Composer

## Instrucciones de Instalación

### 1. Clonar el Repositorio

```bash
git clone https://github.com/w00p/ticketx.git
cd ticketx
```

### 2. Instalar PHP 7.4 y Extensiones Necesarias

```bash
sudo apt install php7.4 php7.4-cli php7.4-common php7.4-mysql php7.4-zip php7.4-gd php7.4-mbstring php7.4-curl php7.4-xml php7.4-bcmath
```

### 3. Instalar MySQL

```bash
sudo apt install mysql-server mysql-client-core-8.0
```

### 4. Configurar Base de Datos

```bash
# Crear la base de datos
sudo mysql -e "CREATE DATABASE ticketx;"

# Crear usuario para la base de datos
sudo mysql -e "CREATE USER 'homestead'@'localhost' IDENTIFIED BY 'secret';"

# Otorgar permisos al usuario sobre la base de datos
sudo mysql -e "GRANT ALL PRIVILEGES ON ticketx.* TO 'homestead'@'localhost';"
sudo mysql -e "FLUSH PRIVILEGES;"
```

### 5. Configurar el Archivo .env

Copiar el archivo .env.example a .env:

```bash
cp .env.example .env
```
http://localhost:8000/
Luego editar el archivo .env con las siguientes configuraciones:

```env
APP_ENV=local
APP_DEBUG=true
APP_KEY=

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=ticketx
DB_USERNAME=homestead
DB_PASSWORD=secret
```

### 6. Instalar Dependencias con Composer

```bash
composer install
```

### 7. Generar la Clave de la Aplicación

```bash
php7.4 artisan key:generate
```

### 8. Migrar la Base de Datos y Poblarla con Datos Iniciales

```bash
php7.4 artisan migrate --seed
```

### 9. Configurar Permisos

```bash
chmod -R 777 storage bootstrap/cache
```

### 10. Iniciar el Servidor de Desarrollo

```bash
php7.4 artisan serve
```

Ahora puedes acceder a la aplicación en: http://localhost:8000

## Credenciales por Defecto

El sistema viene con tres usuarios por defecto:

1. **Admin / Admin**
   - Email: admin@example.com
   - Password: 12345678
   - Permisos: view-backend, manage-users, manage-ticket, manage-permissions, manage-roles

2. **Sally Sixpack / Moderator**
   - Email: sally@example.com
   - Password: 12345678
   - Permisos: view-backend, manage-users, manage-tickets

3. **John Doe / Agent**
   - Email: john@example.com
   - Password: 12345678
   - Permisos: view-backend, manage-tickets

## Conexión a Base de Datos en DBeaver

Para conectar la base de datos en DBeaver, utiliza las siguientes credenciales:

- **Tipo de conexión:** MySQL
- **Host:** localhost (o 127.0.0.1)
- **Puerto:** 3306
- **Nombre de base de datos:** ticketx
- **Usuario:** homestead
- **Contraseña:** secret

## Notas Importantes

- Este proyecto utiliza Laravel 5.2, que requiere PHP 7.x (preferiblemente 7.4) para funcionar correctamente. No es compatible con PHP 8.x.
- Si experimentas problemas con la instalación de dependencias, puedes usar la bandera `--ignore-platform-reqs` en el comando de Composer.
- Para la configuración de avatar, el proyecto usa Cloudinary. Si deseas cambiar el avatar, necesitarás una cuenta en [Cloudinary](http://cloudinary.com/) y configurar las credenciales en el archivo .env.
