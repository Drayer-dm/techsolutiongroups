# TechSolutionGroups

Proyecto web desarrollado con **Laravel 13**, **Tailwind CSS 4** y **Vite**, usando **SQLite** como base de datos por defecto. La autenticación de la API funciona con **JWT** (`php-open-source-saver/jwt-auth`) y la API REST está documentada con **Swagger / OpenAPI** (`darkaonline/l5-swagger`).

> 📘 **Probar la API sin instalar nada más:** con el proyecto levantado, la documentación interactiva queda en **http://localhost:8000/api/documentation** — se ven los 5 endpoints y se ejecutan desde el navegador con *Try it out*. Detalle en [Documentación de la API (Swagger)](#documentación-de-la-api-swagger).

## Requisitos previos

- **PHP** >= 8.3 (con extensiones `pdo_sqlite`, `mbstring`, `xml` y **`sodium`**)
- **Composer**
- **Node.js** >= 18 y **npm**

> **Nota sobre `sodium`:** el paquete de JWT depende de `lcobucci/jwt`, que necesita la extensión `sodium` de PHP. En muchas instalaciones ya viene activa, pero en algunas (por ejemplo Arch con PHP 8.5) hay que instalarla aparte. Ver la sección [Autenticación JWT](#autenticación-jwt) más abajo.

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

### 8. Generar la documentación Swagger

```bash
php artisan l5-swagger:generate
```

> Genera `storage/api-docs/api-docs.json`, que es lo que consume la interfaz de Swagger. El archivo no está versionado, así que **cada integrante tiene que correr este comando en su máquina** después del `composer install`. Detalle completo en [Documentación de la API (Swagger)](#documentación-de-la-api-swagger).

---

## Autenticación JWT

El proyecto usa `php-open-source-saver/jwt-auth` para emitir y validar tokens JWT en la API. **Ya viene declarado en el `composer.json`**, así que un `composer install` normal lo trae. Esta sección documenta los detalles por si hay que instalarlo desde cero o si `composer` se queja de la extensión `sodium`.

### Instalar el paquete (solo si no estuviera ya)

```bash
composer require php-open-source-saver/jwt-auth
```

### Habilitar la extensión `sodium` (si Composer la pide)

Si al instalar aparece un error tipo *"lcobucci/jwt requires ext-sodium"*, es porque falta la extensión `sodium` de PHP. En **Arch** viene en un paquete aparte:

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

## Documentación de la API (Swagger)

La API REST de proyectos está documentada con **OpenAPI** usando `darkaonline/l5-swagger`. La interfaz permite ver todos los endpoints y **ejecutarlos desde el navegador**, sin Postman ni curl.

### 🔗 Acceso directo

Con el servidor levantado (`php artisan serve` o `composer run dev`):

**http://localhost:8000/api/documentation**

Ahí aparecen los **5 endpoints** agrupados bajo el tag **"Proyectos"**, con sus parámetros, cuerpos de ejemplo y códigos de respuesta:

| Método | Ruta | Éxito | Errores |
|---|---|---|---|
| `POST` | `/api/proyectos` | 201 | 422 |
| `GET` | `/api/proyectos` | 200 | — |
| `GET` | `/api/proyectos/{id}` | 200 | 404 |
| `PUT` / `PATCH` | `/api/proyectos/{id}` | 200 | 404, 422 |
| `DELETE` | `/api/proyectos/{id}` | 200 | 404 |

Para probarlos de verdad y no solo mirarlos: **click en el endpoint → "Try it out" → completar los campos → "Execute"**. La respuesta que devuelve es la misma que se obtiene por curl o Postman.

> Estados válidos para el campo `estado`: `pendiente`, `en_curso`, `finalizado`, `cancelado`. Para `created_by` usá un id de usuario que exista (los que carga el seeder).

### Si ya viene en el repo (caso normal)

El paquete **ya está declarado en el `composer.json`**, así que un `composer install` lo trae. Solo hay que generar el JSON y levantar:

```bash
composer install
php artisan l5-swagger:generate
php artisan serve
```

### Instalarlo desde cero (solo si no estuviera)

```bash
# 1. Instalar el paquete (arrastra zircote/swagger-php como dependencia)
composer require darkaonline/l5-swagger

# 2. Publicar la configuración (una sola vez)
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
```

Eso genera dos archivos:

| Archivo | Para qué sirve |
|---|---|
| `config/l5-swagger.php` | Título de la doc, ruta de la interfaz (`/api/documentation` por defecto) y qué carpetas escanea buscando anotaciones (`app/` por defecto, que ya cubre el controlador) |
| `resources/views/vendor/l5-swagger/index.blade.php` | Plantilla de la interfaz. **No hay que tocarla** |

### Cómo están escritas las anotaciones

El proyecto usa **atributos nativos de PHP 8** (`#[OA\...]`), no los docblocks clásicos (`/** @OA\... */`). Los atributos no necesitan la dependencia extra `doctrine/annotations`, y con PHP 8.3 son la forma recomendada por el propio mantenedor de `swagger-php`.

En `app/Http/Controllers/Api/ProyectoController.php`, arriba del archivo:

```php
use OpenApi\Attributes as OA;
```

> ⚠️ Tiene que decir **`Attributes`**, no `Annotations`. Con `Annotations` el archivo compila igual, pero `swagger-php` no reconoce nada y falla con `Required @OA\Info() not found`.

Bloque global, justo antes de la declaración de la clase:

```php
#[OA\Info(
    version: "1.0.0",
    title: "API REST de proyectos",
    description: "API REST de proyectos para la Evaluación Sumativa Unidad 3"
)]
class ProyectoController extends Controller
```

Y cada método lleva su atributo encima de la firma. Por ejemplo, `show()`:

```php
#[OA\Get(
    path: "/api/proyectos/{id}",
    summary: "Buscar un proyecto por su ID",
    tags: ["Proyectos"],
    parameters: [
        new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
    ],
    responses: [
        new OA\Response(response: 200, description: "Proyecto encontrado"),
        new OA\Response(response: 404, description: "No existe un proyecto con ese id"),
    ]
)]
public function show($id): JsonResponse
```

> Un docblock normal (`/** */` con notas para humanos) puede convivir con el atributo, siempre que vaya **arriba** de él y nunca en medio.

### Regenerar después de tocar una anotación

Cada vez que se cambia un atributo hay que volver a generar el JSON:

```bash
php artisan l5-swagger:generate
```

Señal de éxito: el mensaje `Regenerating docs default` **sin** ningún `ErrorException` debajo.

Mientras se desarrolla, se puede evitar el comando manual agregando esto al `.env` para que se regenere en cada request:

```env
L5_SWAGGER_GENERATE_ALWAYS=true
```

### Problemas típicos

| Síntoma | Causa | Solución |
|---|---|---|
| `Required @OA\Info() not found` | El `use` dice `OpenApi\Annotations as OA` | Cambiarlo por `OpenApi\Attributes as OA` |
| Error de sintaxis apuntando al `#[OA\Info(...)]` | Quedó un `;` después del `)]` | Un atributo de PHP cierra en `)]` y ahí termina, sin punto y coma |
| `l5-swagger:generate` falla pero `php -l` dice que el archivo está bien | Falta cerrar un array (`responses: [...]` o `parameters: [...]`) antes del `)]` final | Revisar los corchetes de los arrays uno por uno |
| `/api/documentation` da 404 | Nunca se corrió `l5-swagger:generate`, o falta publicar la config | Correr los dos comandos de la sección de instalación |
| `PHP Warning: Module "mysqli" is already loaded` | El módulo está cargado dos veces en el `php.ini` local | No tiene relación con Swagger, es solo ruido: se puede ignorar |

Lint rápido si algo no compila:

```bash
php -l app/Http/Controllers/Api/ProyectoController.php
```

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
php artisan l5-swagger:generate
composer run dev
```

> Si `composer install` falla por `ext-sodium`, instalá la extensión (ver [Autenticación JWT](#autenticación-jwt)) y reintentá.

Con eso levantado:

- **Web:** http://localhost:8000
- **Documentación de la API (Swagger):** http://localhost:8000/api/documentation