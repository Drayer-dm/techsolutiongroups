# TechSolutionGroups

Proyecto web desarrollado con **Laravel 13**, **Tailwind CSS 4** y **Vite**, usando **SQLite** como base de datos por defecto.

## Requisitos previos

- **PHP** >= 8.3 (con extensiones `pdo_sqlite`, `mbstring`, `xml`, etc.)
- **Composer**
- **Node.js** >= 18 y **npm**

---

## Instalación desde cero

Cloná el repositorio y entrá a la carpeta:

```bash
git clone https://github.com/Drayer-dm/techsolutiongroups.git
cd techsolutiongroups
```

### 1. Dependencias de PHP

```bash
composer install
```

> `composer install` respeta las versiones del `composer.lock`. **No uses `composer update`** al levantar el proyecto: eso actualizaría las dependencias y reescribiría el lock.

### 2. Dependencias de JavaScript

```bash
npm install
```

> Igual que arriba: `npm install` lee el `package-lock.json`. Evitá `npm update` en el setup inicial.

### 3. Crear el archivo `.env`

El `.env` no está versionado (está en `.gitignore`), así que lo generás desde el ejemplo:

```bash
cp .env.example .env
```

### 4. Generar la APP_KEY

```bash
php artisan key:generate
```

> Este comando escribe la key **dentro del `.env`**, por eso el `.env` tiene que existir antes (paso 3).

### 5. Crear la base de datos SQLite

El proyecto usa SQLite (`DB_CONNECTION=sqlite`). Hay que crear el archivo vacío antes de migrar:

```bash
# Linux / macOS
touch database/database.sqlite

# Windows (PowerShell)
ni database/database.sqlite
```

### 6. Ejecutar las migraciones

```bash
php artisan migrate
```

> El archivo `database/database.sqlite` debe existir antes de este paso, o SQLite tira error de "database does not exist".

---

## Levantar el proyecto

### Opción A — Todo junto (recomendado)

El `composer.json` incluye un script que levanta el servidor de Laravel, la cola, los logs y Vite al mismo tiempo:

```bash
composer run dev
```

### Opción B — En dos terminales

**Terminal 1** (servidor de Laravel → http://127.0.0.1:8000):

```bash
php artisan serve
```

**Terminal 2** (Vite / assets con hot-reload):

```bash
npm run dev
```

Para compilar los assets para producción:

```bash
npm run build
```

---

## Cambiar de la rama `main` a `dev`

Traé las ramas remotas y cambiate a `dev`:

```bash
git fetch origin
git switch dev
```

Alternativa con el comando clásico:

```bash
git checkout dev
```

Para volver a `main`:

```bash
git switch main
```

Ver en qué rama estás y las disponibles:

```bash
git branch -a
```

---

## Tailwind CSS 4 (ya instalado)

Tailwind **ya viene configurado** en este proyecto a través del plugin oficial de Vite (`@tailwindcss/vite`), por lo que **no necesitás inicializarlo** (no hay `tailwind.config.js` ni `npx tailwindcss init`). Se compila automáticamente cuando corrés `npm run dev` o `npm run build`.

Si tuvieras que instalarlo desde cero en otro proyecto Laravel + Vite, los pasos serían:

```bash
npm install tailwindcss @tailwindcss/vite
```

Agregar el plugin en `vite.config.js`:

```js
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        // ...otros plugins
        tailwindcss(),
    ],
});
```

E importar Tailwind en tu CSS principal (por ejemplo `resources/css/app.css`):

```css
@import "tailwindcss";
```

---

## Resumen rápido (copy-paste)

```bash
git clone https://github.com/Drayer-dm/techsolutiongroups.git
cd techsolutiongroups
composer install
npm install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
composer run dev
```
