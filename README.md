<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>
 
## LEC Fantasy

LEC Fantasy es una aplicación web desarrollada con **Laravel 12**, **PHP 8.2** y **Vite** que permite gestionar una liga fantasy basada en la LEC.

Este repositorio contiene el código del backend (Laravel) y del frontend (Vite + TailwindCSS).

---

## Requisitos previos

- **PHP** >= 8.2
- **Composer**
- **Node.js** y **npm**
- **MySQL** (o MariaDB) instalado y funcionando
- Opcional: **Git** para clonar el repositorio

---

## 1. Clonar el proyecto

Clona el repositorio y entra en la carpeta del proyecto:

```bash
git clone https://github.com/TU_USUARIO/TU_REPO.git
cd TU_REPO
```

Sustituye `TU_USUARIO` y `TU_REPO` por los valores reales de tu proyecto en GitHub.

---

## 2. Instalar dependencias

Instala las dependencias de PHP con Composer:

```bash
composer install
```

Instala las dependencias de Node:

```bash
npm install
```

---

## 3. Configurar variables de entorno

1. Copia el archivo de ejemplo `.env.example` a `.env`:

   - En Linux/Mac:

     ```bash
     cp .env.example .env
     ```

   - En Windows (PowerShell):

     ```powershell
     copy .env.example .env
     ```

2. Abre el archivo `.env` y ajusta al entorno local:

   - URL de la aplicación:

     ```env
     APP_URL=http://localhost
     ```

   - Configuración de la base de datos (por defecto el proyecto usa estos valores):

     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3307
     DB_DATABASE=lec_fantasy
     DB_USERNAME=root
     DB_PASSWORD=
     ```

   - Completa tus propias credenciales para servicios externos (Cloudinary, Google, Pandascore, etc.) en las variables correspondientes. **No uses las claves de ejemplo en producción.**

3. Genera la clave de la aplicación:

```bash
php artisan key:generate
```

---

## 4. Crear la base de datos

Antes de ejecutar las migraciones, debes crear la base de datos en tu servidor MySQL.

1. Entra en tu cliente MySQL (phpMyAdmin, TablePlus, consola, etc.).
2. Crea una base de datos con el mismo nombre que tengas en `DB_DATABASE` (por defecto `lec_fantasy`).

Ejemplo en SQL:

```sql
CREATE DATABASE lec_fantasy CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Asegúrate también de que el puerto (`DB_PORT`) y el usuario/contraseña (`DB_USERNAME`, `DB_PASSWORD`) coinciden con tu configuración local.

---

## 5. Ejecutar migraciones (y seeders opcionales)

Una vez creada la base de datos y configurado el `.env`, ejecuta:

```bash
php artisan migrate
```

Si el proyecto incluye seeders y quieres datos de prueba, puedes ejecutar:

```bash
php artisan db:seed
```

---

## 6. Levantar el proyecto en local

Tienes dos formas de levantar el entorno de desarrollo.

### Opción A: Comandos separados

En una terminal, levanta el servidor de Laravel:

```bash
php artisan serve
```

En otra terminal, levanta Vite para los assets del frontend:

```bash
npm run dev
```

Por defecto, podrás acceder a la aplicación en:

- `http://127.0.0.1:8000`

### Opción B: Script de desarrollo con Composer

Este proyecto define un script `dev` en `composer.json` que arranca varios procesos en paralelo (servidor, colas, logs y Vite):

```bash
composer dev
```

Este comando ejecuta internamente:

- `php artisan serve`
- `php artisan queue:listen --tries=1`
- `php artisan pail --timeout=0`
- `npm run dev`

---

## 7. Compilar assets para producción

Para generar los assets optimizados para producción, ejecuta:

```bash
npm run build
```

---

