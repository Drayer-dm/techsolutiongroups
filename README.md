# TechSolutionGroups

Proyecto web desarrollado con **Laravel 13**, **Tailwind CSS 4** y **Vite**, usando **SQLite** como base de datos por defecto. La autenticación de la API funciona con **JWT** (`php-open-source-saver/jwt-auth`).

## Requisitos previos

- **PHP** >= 8.3 (con extensiones `pdo_sqlite`, `mbstring`, `xml` y **`sodium`**)
- **Composer**
- **Node.js** >= 18 y **npm**

> **Nota sobre `sodium`:** el paquete de JWT depende de `lcobucci/jwt`, que necesita la extensión `sodium` de PHP. En muchas instalaciones ya viene activa, pero en algunas (por ejemplo Arch/CachyOS con PHP 8.5) hay que instalarla aparte. Ver la sección [Autenticación JWT](#autenticación-jwt) más abajo.

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

Si `composer install` falla pidiendo la extensión `sodium`, saltá a la sección [Autenticación JWT](#autenticación-jwt) para instalarla y volvé a correrlo.

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

### 5. Generar el JWT_SECRET

La autenticación por token necesita un secreto propio, que también vive en el `.env`. Como el `.env` no viaja en los push, **cada integrante tiene que correr esto en su máquina**, aunque otro ya lo haya hecho en la suya:

```bash
php artisan jwt:secret
```

> Escribe la línea `JWT_SECRET=...` dentro del `.env`. Si el comando no existe, ver [Autenticación JWT](#autenticación-jwt) (falta publicar la config del paquete).

### 6. Crear la base de datos SQLite

El proyecto usa SQLite (`DB_CONNECTION=sqlite`). Hay que crear el archivo vacío antes de migrar:

```bash
# Linux / macOS
touch database/database.sqlite

# Windows (PowerShell)
ni database/database.sqlite
```

### 7. Ejecutar las migraciones y los seeders

```bash
php artisan migrate --seed
```

> El archivo `database/database.sqlite` debe existir antes de este paso, o SQLite tira error de "database does not exist". El `--seed` carga los datos de prueba (usuarios y proyectos).

Si en algún momento querés reconstruir la base desde cero (borra todo y vuelve a migrar + sembrar):

```bash
php artisan migrate:fresh --seed
```

---

## Autenticación JWT

El proyecto usa `php-open-source-saver/jwt-auth` para emitir y validar tokens JWT en la API. **Ya viene declarado en el `composer.json`**, así que un `composer install` normal lo trae. Esta sección documenta los detalles por si hay que instalarlo desde cero o si `composer` se queja de la extensión `sodium`.

### Instalar el paquete (solo si no estuviera ya)

```bash
composer require php-open-source-saver/jwt-auth
```

### Habilitar la extensión `sodium` (si Composer la pide)

Si al instalar aparece un error tipo *"lcobucci/jwt requires ext-sodium"*, es porque falta la extensión `sodium` de PHP. En **Arch / CachyOS** viene en un paquete aparte:

```bash
# 1. Instalar el paquete de la extensión
sudo pacman -S php-sodium

# 2. Verificar que el módulo quedó disponible
ls /usr/lib/php/modules/ | grep sodium   # debería mostrar sodium.so

# 3. Habilitarla en php.ini (si no quedó activa sola)
grep -q '^extension=sodium' /etc/php/php.ini || echo 'extension=sodium' | sudo tee -a /etc/php/php.ini

# 4. Confirmar que PHP la carga
php -m | grep sodium                      # debería imprimir: sodium
```

> En otras distros el paquete puede llamarse distinto (`php-sodium`, `libsodium`, etc.). Lo importante es que `php -m | grep sodium` imprima `sodium`.

### Publicar la config y generar el secreto

```bash
# Publica config/jwt.php (habilita el comando jwt:secret)
php artisan vendor:publish --provider="PHPOpenSourceSaver\JWTAuth\Providers\LaravelServiceProvider"

# Genera el JWT_SECRET dentro del .env
php artisan jwt:secret
```

### Configuración necesaria

Estos ajustes ya están en el repo, pero para referencia:

**`config/auth.php`** — el guard `api` usa el driver `jwt`, y el provider apunta al modelo `Usuario`:

```php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
    'api' => [
        'driver' => 'jwt',
        'provider' => 'users',
    ],
],

'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => env('AUTH_MODEL', App\Models\Usuario::class),
    ],
],
```

**Modelo `Usuario`** — implementa la interfaz `JWTSubject` (métodos `getJWTIdentifier()` y `getJWTCustomClaims()`), y como la columna de la clave se llama `clave` (no `password`), sobrescribe `getAuthPasswordName()`.

**Middleware `JwtMiddleware`** — valida el token en cada petición a rutas protegidas. Está registrado en `bootstrap/app.php` con el alias `jwt.custom` y se aplica a las rutas de `routes/api.php`.

---

## Probar la API con tokens (tinker + curl)

Para probar los endpoints protegidos necesitás un token válido. Si el login todavía no está disponible, podés generar uno a mano desde **tinker**.

### 1. Generar un token de prueba

```bash
php artisan tinker
```

Dentro de tinker:

```php
$token = auth('api')->login(App\Models\Usuario::first());
echo $token;
```

Eso imprime un JWT (una cadena larga tipo `eyJ0eXAi...`). Copialo.

> Si tira *"Auth guard [api] is not defined"*, falta el guard `api` en `config/auth.php` (ver sección anterior). Si `Usuario::first()` es `null`, corré primero `php artisan migrate:fresh --seed`.

### 2. Pegarle a una ruta protegida

Con el servidor levantado (`php artisan serve`), en otra terminal:

```bash
# Sin token → debería devolver 401
curl -i http://127.0.0.1:8000/api/me \
  -H "Accept: application/json"

# Con token válido → debería devolver los datos del usuario (200)
curl -s http://127.0.0.1:8000/api/me \
  -H "Accept: application/json" \
  -H "Authorization: Bearer PEGA_EL_TOKEN_AQUI"
```

El contraste entre ambas respuestas (401 sin token, 200 con token) confirma que el middleware JWT está validando correctamente.

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
php artisan jwt:secret
touch database/database.sqlite
php artisan migrate --seed
composer run dev
```

> Si `composer install` falla por `ext-sodium`, instalá la extensión (ver [Autenticación JWT](#autenticación-jwt)) y reintentá.
