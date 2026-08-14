# Guía de instalación — TechSolutionGroups

Guía completa para dejar el proyecto funcionando desde cero en una máquina nueva.
Está escrita **para Windows 11 + PowerShell + VS Code** (que es el entorno de trabajo actual), y al final tiene un [apéndice para Linux / macOS](#apéndice-a--linux--macos).

> **Repositorio:** https://github.com/Drayer-dm/techsolutiongroups
> **Rama de trabajo:** `dev`

---

## Índice

1. [Qué stack usa el proyecto](#1-qué-stack-usa-el-proyecto)
2. [Requisitos previos](#2-requisitos-previos)
3. [Instalar y activar PHP](#3-instalar-y-activar-php)
4. [Instalar Composer, Node y Git](#4-instalar-composer-node-y-git)
5. [Clonar el proyecto](#5-clonar-el-proyecto)
6. [Instalación paso a paso](#6-instalación-paso-a-paso)
7. [Verificar que todo quedó bien](#7-verificar-que-todo-quedó-bien)
8. [Levantar el proyecto](#8-levantar-el-proyecto)
9. [Credenciales y rutas disponibles](#9-credenciales-y-rutas-disponibles)
10. [Configurar VS Code](#10-configurar-vs-code)
11. [Comandos del día a día](#11-comandos-del-día-a-día)
12. [Solución de problemas](#12-solución-de-problemas)
13. [Apéndice A — Linux / macOS](#apéndice-a--linux--macos)
14. [Apéndice B — Resumen copy-paste](#apéndice-b--resumen-copy-paste)

---

## 1. Qué stack usa el proyecto

| Componente | Versión requerida | Para qué |
|---|---|---|
| **PHP** | `^8.3` (probado en 8.5.8) | Lenguaje del backend |
| **Laravel Framework** | `^13.8` (instalado: 13.25) | Framework principal |
| **Composer** | 2.x | Gestor de dependencias PHP |
| **Node.js** | >= 18 (probado en 26.x) | Solo para compilar los assets |
| **npm** | 9+ | Gestor de dependencias JS |
| **Vite** | `^8.0` | Bundler / hot-reload de assets |
| **Tailwind CSS** | `^4.3` | Estilos (vía `@tailwindcss/vite`) |
| **SQLite** | incluido en PHP | Base de datos (archivo local) |
| **JWT** | `php-open-source-saver/jwt-auth ^2.9` | Autenticación de la API |
| **Git** | 2.x | Control de versiones |

**No hace falta** instalar MySQL, XAMPP, Laragon, Docker ni un servidor Apache/Nginx. La base es un archivo SQLite y el servidor de desarrollo lo levanta el propio PHP con `php artisan serve`.

---

## 2. Requisitos previos

Antes de empezar, abrí **PowerShell** y verificá qué tenés instalado:

```powershell
php -v
composer -V
node -v
npm -v
git --version
```

Si alguno tira `no se reconoce como un comando`, seguí la sección correspondiente más abajo. Salida esperada (aproximada):

```
PHP 8.5.8 (cli) ...
Composer version 2.10.2
v26.5.0
11.17.0
git version 2.55.0.windows.3
```

---

## 3. Instalar y activar PHP

> Si `php -v` ya te devuelve **8.3 o superior**, saltá al [paso 3.3](#33-activar-las-extensiones-obligatorias) — igual tenés que revisar las extensiones.

### 3.1. Descargar PHP

1. Entrá a https://windows.php.net/download/
2. Descargá la versión **8.3 o superior**, variante **Thread Safe (TS) x64**, en `.zip`.
3. Descomprimí el contenido en una carpeta simple, sin espacios. En esta máquina está en:

```
D:\php
```

### 3.2. Agregar PHP al PATH

Sin esto, `php` solo funciona si estás parado dentro de `D:\php`.

**Opción gráfica (recomendada):**

1. Tecla `Windows` → escribí `variables de entorno` → *Editar las variables de entorno del sistema*.
2. Botón **Variables de entorno…**
3. En *Variables del sistema*, seleccioná `Path` → **Editar** → **Nuevo** → pegá `D:\php`
4. Aceptar en todas las ventanas.
5. **Cerrá y volvé a abrir PowerShell** (y VS Code) para que tome el cambio.

**Verificación:**

```powershell
php -v
(Get-Command php).Source     # debería imprimir D:\php\php.exe
```

### 3.3. Activar las extensiones obligatorias

Este es el punto donde falla el 90% de las instalaciones. PHP viene con las extensiones **desactivadas por defecto**.

**Paso 1 — Crear el `php.ini` si no existe.** En la carpeta de PHP hay un archivo `php.ini-development`. Copialo:

```powershell
Copy-Item D:\php\php.ini-development D:\php\php.ini
```

> Si `php --ini` ya te muestra un *"Loaded Configuration File"* con una ruta real, el archivo ya existe: **no lo sobrescribas**, solo editalo.

**Paso 2 — Editarlo.** Abrilo con VS Code:

```powershell
code D:\php\php.ini
```

**Paso 3 — Descomentar** (quitarle el `;` del inicio) estas líneas. Usá `Ctrl+F` para buscar cada una:

```ini
extension_dir = "ext"

extension=curl
extension=fileinfo
extension=mbstring
extension=openssl
extension=pdo_sqlite
extension=sodium
extension=zip
```

Referencia de para qué sirve cada una:

| Extensión | Por qué es obligatoria |
|---|---|
| `pdo_sqlite` | La base de datos del proyecto. Sin esto: *"could not find driver"* |
| `sodium` | La usa `lcobucci/jwt` (autenticación JWT). Sin esto Composer se niega a instalar |
| `openssl` | HTTPS, cifrado de la `APP_KEY`, sesiones |
| `mbstring` | Manejo de strings UTF-8, obligatoria en Laravel |
| `fileinfo` | Detección de tipos MIME (subida de archivos) |
| `curl` | Peticiones HTTP salientes |
| `zip` | Composer la usa para descomprimir paquetes |

**Paso 4 — Guardar el archivo y verificar.** Cerrá y reabrí PowerShell, después:

```powershell
php -m
```

Ese comando lista los módulos cargados. Para chequear los críticos de una:

```powershell
php -r "foreach (['pdo_sqlite','sodium','mbstring','openssl','curl','fileinfo','zip'] as $e) { printf('%-12s %s%s', $e, extension_loaded($e) ? 'OK' : 'FALTA', PHP_EOL); }"
```

Todas tienen que decir `OK` antes de seguir.

---

## 4. Instalar Composer, Node y Git

### Composer

1. Descargá el instalador de https://getcomposer.org/Composer-Setup.exe
2. Ejecutalo. Cuando pida la ruta de PHP, apuntá a `D:\php\php.exe`.
3. Dejá marcada la opción de agregarlo al PATH.
4. Verificá:

```powershell
composer -V
```

### Node.js

1. Descargá el instalador **LTS** de https://nodejs.org/
2. Instalación estándar (siguiente → siguiente). Ya agrega Node y npm al PATH.
3. Verificá:

```powershell
node -v
npm -v
```

### Git

1. Descargá de https://git-scm.com/download/win
2. Instalación estándar.
3. Configurá tu identidad (una sola vez por máquina):

```powershell
git config --global user.name "Tu Nombre"
git config --global user.email "tu@correo.com"
```

### Habilitar scripts de PowerShell (necesario para npm)

Windows por defecto bloquea `npm.ps1`. Si al correr `npm` ves *"no se puede cargar el archivo … npm.ps1 porque la ejecución de scripts está deshabilitada"*, ejecutá una sola vez:

```powershell
Set-ExecutionPolicy -Scope CurrentUser -ExecutionPolicy RemoteSigned
```

Confirmá con `S` / `Y`.

---

## 5. Clonar el proyecto

```powershell
cd D:\Pruebas\EVA_02
git clone https://github.com/Drayer-dm/techsolutiongroups.git
cd techsolutiongroups
git switch dev
```

> Si ya tenés la carpeta, solo entrá a ella y traé los últimos cambios:
> ```powershell
> cd D:\Pruebas\EVA_02\techsolutiongroups
> git fetch origin
> git switch dev
> git pull
> ```

---

## 6. Instalación paso a paso

Todos los comandos se ejecutan **parado en la raíz del proyecto** (`D:\Pruebas\EVA_02\techsolutiongroups`).

### Paso 1 — Dependencias de PHP

```powershell
composer install
```

> ⚠️ Usá `install`, **nunca `composer update`** al levantar el proyecto. `install` respeta las versiones exactas del `composer.lock`; `update` las actualiza y reescribe el lock, lo que rompe la paridad con el resto del equipo.

Esto crea la carpeta `vendor/` (~50 MB, no está versionada).

### Paso 2 — Dependencias de JavaScript

```powershell
npm install
```

Esto crea `node_modules/` (tampoco está versionada).

> El proyecto tiene un `.npmrc` con `ignore-scripts=true`. Es **intencional** (medida de seguridad: evita que un paquete ejecute scripts de post-instalación). No lo cambies.

### Paso 3 — Crear el archivo `.env`

El `.env` guarda la configuración local y **está en `.gitignore`**, así que nunca viaja en un `git clone`. Hay que generarlo desde la plantilla:

```powershell
Copy-Item .env.example .env
```

> En PowerShell **no existe `cp`** como en Linux — el equivalente es `Copy-Item`.

### Paso 4 — Generar la APP_KEY

```powershell
php artisan key:generate
```

Esta clave cifra las sesiones y cookies. El comando la escribe **dentro del `.env`**, por eso el paso 3 tiene que estar hecho antes.

### Paso 5 — Generar el JWT_SECRET

```powershell
php artisan jwt:secret
```

Es el secreto con el que se firman los tokens de la API. Como vive en el `.env`, **cada integrante del equipo tiene que generarlo en su propia máquina**, aunque otro ya lo haya hecho en la suya.

Cuando pregunte si querés sobrescribir un secreto existente, respondé `yes` en una instalación nueva.

### Paso 6 — Crear el archivo de la base de datos

El proyecto usa SQLite, que es literalmente un archivo. Hay que crearlo vacío antes de migrar:

```powershell
if (-not (Test-Path database\database.sqlite)) { New-Item -ItemType File database\database.sqlite }
```

> ⚠️ **No uses `New-Item -Force`** sobre este archivo: si ya existe, `-Force` lo **vacía** y perdés todos los datos. El `if` de arriba lo evita.
> En PowerShell tampoco existe `touch`.

### Paso 7 — Crear las tablas y cargar datos de prueba

```powershell
php artisan migrate --seed
```

Esto ejecuta las 4 migraciones (`cache`, `jobs`, `usuarios`, `proyectos`) y carga el usuario de prueba.

Si en algún momento querés **reconstruir la base desde cero** (borra todo, vuelve a migrar y a sembrar):

```powershell
php artisan migrate:fresh --seed
```

### Paso 8 — Compilar los assets

```powershell
npm run build
```

Genera `public/build/` con el CSS de Tailwind y el JS compilados. **Sin este paso (o sin `npm run dev` corriendo) las vistas tiran error de manifest de Vite.**

---

## 7. Verificar que todo quedó bien

Corré este chequeo antes de levantar el servidor:

```powershell
php artisan --version
```
→ debería decir `Laravel Framework 13.x`

```powershell
php artisan migrate:status
```
→ las 4 migraciones tienen que aparecer como `Ran`:

```
0001_01_01_000001_create_cache_table ....... [1] Ran
0001_01_01_000002_create_jobs_table ........ [1] Ran
2026_08_07_171312_create_usuarios_table .... [1] Ran
2026_08_07_171926_create_proyectos_table ... [1] Ran
```

```powershell
php artisan route:list
```
→ tiene que listar las rutas web (`/`, `/productos`, `/ingreso`, …) y la de API (`/api/me`).

```powershell
Select-String -Path .env -Pattern '^APP_KEY=|^JWT_SECRET='
```
→ ambas líneas tienen que tener un valor después del `=`, no estar vacías.

---

## 8. Levantar el proyecto

### Opción A — Todo junto (recomendada)

El `composer.json` trae un script que levanta **el servidor, la cola de trabajos, los logs en vivo y Vite** al mismo tiempo, en una sola terminal con salida coloreada:

```powershell
composer run dev
```

Verás cuatro procesos: `server`, `queue`, `logs`, `vite`.
Para cortarlos todos: `Ctrl + C`.

### Opción B — Dos terminales (más control)

**Terminal 1 — servidor de Laravel:**

```powershell
php artisan serve
```
→ http://127.0.0.1:8000

**Terminal 2 — Vite con hot-reload:**

```powershell
npm run dev
```

> Con `npm run dev` corriendo, cualquier cambio en Blade, CSS o JS se refleja en el navegador sin recargar a mano (el `vite.config.js` tiene `refresh: true`).

### Abrir en el navegador

👉 **http://127.0.0.1:8000**

---

## 9. Credenciales y rutas disponibles

### Usuario de prueba (creado por el seeder)

| Campo | Valor |
|---|---|
| Correo | `test@example.com` |
| Clave | `password` |

> Se crea al correr `php artisan migrate --seed`. La clave se guarda hasheada automáticamente (el modelo `Usuario` tiene el cast `hashed`).

### Rutas web

| Método | Ruta | Descripción | Acceso |
|---|---|---|---|
| GET | `/` | Página de inicio | Público |
| GET | `/productos` | Catálogo de productos | Público |
| GET | `/nosotros` | Quiénes somos | Público |
| GET | `/contacto` | Formulario de contacto | Público |
| GET | `/faq` | Preguntas frecuentes | Público |
| GET | `/cobertura` | Zonas de cobertura | Público |
| GET | `/servicios-proyectos` | Servicios y proyectos | Público |
| GET / POST | `/registro` | Registro de usuario | Solo visitantes |
| GET / POST | `/ingreso` | Inicio de sesión (límite: 5 intentos/min) | Solo visitantes |
| GET | `/registro-proyecto` | Listado de proyectos del usuario | Requiere sesión |
| POST | `/registro-proyecto` | Crear proyecto | Requiere sesión |
| PATCH | `/registro-proyecto/{id}` | Editar proyecto | Requiere sesión |
| DELETE | `/registro-proyecto/{id}` | Eliminar proyecto | Requiere sesión |
| POST | `/salir` | Cerrar sesión | Requiere sesión |

### Ruta de API (protegida con JWT)

| Método | Ruta | Descripción |
|---|---|---|
| GET | `/api/me` | Devuelve el usuario del token. Middleware `jwt.custom` |

**Cómo probarla.** Generá un token desde tinker:

```powershell
php artisan tinker
```

Dentro de tinker:

```php
$token = auth('api')->login(App\Models\Usuario::first());
echo $token;
```

Copiá la cadena larga (`eyJ0eXAi...`) y salí con `exit`. Con el servidor levantado, en otra terminal:

```powershell
# Sin token → 401 Unauthorized
curl.exe -i http://127.0.0.1:8000/api/me -H "Accept: application/json"

# Con token → 200 y los datos del usuario
curl.exe -s http://127.0.0.1:8000/api/me -H "Accept: application/json" -H "Authorization: Bearer PEGA_EL_TOKEN_AQUI"
```

> En PowerShell usá **`curl.exe`** (con extensión). `curl` a secas es un alias de `Invoke-WebRequest`, que no entiende los flags `-i` / `-H`.

El contraste 401 vs 200 confirma que el middleware JWT está validando bien.

---

## 10. Configurar VS Code

### Extensiones recomendadas

Instalalas desde el panel de extensiones (`Ctrl+Shift+X`) o por terminal:

```powershell
code --install-extension bmewburn.vscode-intelephense-client
code --install-extension onecentlin.laravel-blade
code --install-extension bradlc.vscode-tailwindcss
code --install-extension EditorConfig.EditorConfig
code --install-extension amiralizadeh9480.laravel-extra-intellisense
```

| Extensión | Para qué |
|---|---|
| **PHP Intelephense** | Autocompletado y navegación en PHP |
| **Laravel Blade Snippets** | Resaltado y snippets de `.blade.php` |
| **Tailwind CSS IntelliSense** | Autocompletado de clases de Tailwind |
| **EditorConfig** | Respeta el `.editorconfig` del repo (indentación, saltos de línea) |
| **Laravel Extra Intellisense** | Autocompletado de rutas, vistas y configs |

### Apuntar VS Code al PHP correcto

Si Intelephense se queja de la versión de PHP, abrí la configuración (`Ctrl+,`), buscá `php.executablePath` y ponelo en:

```
D:\\php\\php.exe
```

### Terminal integrada

VS Code abre PowerShell por defecto. Si al abrir la terminal integrada `php` no se reconoce, es porque VS Code se abrió **antes** de que agregaras PHP al PATH: cerralo por completo y volvé a abrirlo.

---

## 11. Comandos del día a día

```powershell
# --- Levantar ---
composer run dev                  # servidor + cola + logs + vite, todo junto
php artisan serve                 # solo el servidor
npm run dev                       # solo vite (hot-reload)
npm run build                     # compilar assets para producción

# --- Base de datos ---
php artisan migrate               # aplicar migraciones pendientes
php artisan migrate --seed        # migrar + cargar datos de prueba
php artisan migrate:fresh --seed  # ⚠️ borra TODO y reconstruye
php artisan migrate:status        # ver qué migraciones corrieron
php artisan db:seed               # solo sembrar

# --- Inspección ---
php artisan route:list            # todas las rutas
php artisan tinker                # consola interactiva
php artisan pail                  # ver logs en vivo

# --- Limpiar cachés (ante comportamiento raro) ---
php artisan optimize:clear        # limpia config, rutas, vistas y cache de una

# --- Calidad y tests ---
composer test                     # correr la suite de tests
vendor\bin\pint                   # formatear el código al estándar Laravel

# --- Git ---
git status
git switch dev
git pull
git branch -a                     # ver todas las ramas
```

### Después de un `git pull`

Si alguien tocó dependencias o migraciones, corré:

```powershell
composer install
npm install
php artisan migrate
npm run build
php artisan optimize:clear
```

---

## 12. Solución de problemas

### ❌ `php` no se reconoce como un comando

PHP no está en el PATH, o abriste la terminal antes de agregarlo.
→ Revisá el [paso 3.2](#32-agregar-php-al-path). **Cerrá y reabrí PowerShell y VS Code.**

---

### ❌ `could not find driver` / `Database file at path ... does not exist`

Falta la extensión `pdo_sqlite`, o falta el archivo de base de datos.

```powershell
# 1. ¿Está la extensión?
php -m | Select-String sqlite

# 2. Si no aparece: descomentar extension=pdo_sqlite en D:\php\php.ini y reabrir la terminal

# 3. ¿Existe el archivo?
Test-Path database\database.sqlite

# 4. Si dice False:
New-Item -ItemType File database\database.sqlite
php artisan migrate --seed
```

---

### ❌ `requires ext-sodium * -> it is missing from your system`

Composer se niega a instalar porque falta `sodium` (la necesita el paquete de JWT).

→ Descomentá `extension=sodium` en `D:\php\php.ini`, reabrí la terminal, verificá con `php -m | Select-String sodium` y volvé a correr `composer install`.

---

### ❌ `No application encryption key has been specified`

Falta la `APP_KEY` en el `.env`.

```powershell
php artisan key:generate
php artisan optimize:clear
```

---

### ❌ `Secret is not set` / errores de JWT

Falta el `JWT_SECRET`.

```powershell
php artisan jwt:secret
php artisan config:clear
```

Si el comando `jwt:secret` **no existe**, falta publicar la config del paquete:

```powershell
php artisan vendor:publish --provider="PHPOpenSourceSaver\JWTAuth\Providers\LaravelServiceProvider"
php artisan jwt:secret
```

---

### ❌ `Auth guard [api] is not defined`

El guard `api` no está configurado en `config/auth.php`. Ya viene en el repo, así que casi siempre es caché vieja:

```powershell
php artisan config:clear
```

---

### ❌ `Unable to locate file in Vite manifest: resources/css/app.css`

No compilaste los assets.

```powershell
npm run build      # compilación única
# o dejá corriendo:
npm run dev        # modo desarrollo con hot-reload
```

---

### ❌ La página carga pero **sin estilos**

Suele ser un `public/hot` que quedó huérfano de una sesión anterior de Vite que no cerró bien:

```powershell
Remove-Item public\hot -ErrorAction SilentlyContinue
npm run build
```

---

### ❌ `Failed to listen on 127.0.0.1:8000 (reason: ...)`

El puerto 8000 está ocupado. Usá otro:

```powershell
php artisan serve --port=8001
```

O buscá y cerrá el proceso que lo tiene tomado:

```powershell
Get-NetTCPConnection -LocalPort 8000 | Select-Object OwningProcess
Stop-Process -Id <EL_ID_QUE_SALIO>
```

---

### ❌ `npm.ps1 ... la ejecución de scripts está deshabilitada`

Política de ejecución de PowerShell.

```powershell
Set-ExecutionPolicy -Scope CurrentUser -ExecutionPolicy RemoteSigned
```

---

### ❌ `UNIQUE constraint failed: usuarios.correo`

Corriste el seeder dos veces y el usuario `test@example.com` ya existe. No es un error real. Si querés partir limpio:

```powershell
php artisan migrate:fresh --seed
```

---

### ❌ `The stream or file "storage/logs/laravel.log" could not be opened`

Faltan permisos de escritura en las carpetas de trabajo. En Windows es raro, pero si pasa:

```powershell
icacls storage /grant "$env:USERNAME:(OI)(CI)F" /T
icacls bootstrap\cache /grant "$env:USERNAME:(OI)(CI)F" /T
```

---

### ❌ Cambié algo en `.env` y no surte efecto

Laravel cachea la configuración.

```powershell
php artisan config:clear
```

---

### 🔧 Reinicio nuclear (cuando nada funciona)

Borra todo lo generado y reconstruye. **Perdés los datos de la base local.**

```powershell
Remove-Item -Recurse -Force vendor, node_modules, public\build -ErrorAction SilentlyContinue
Remove-Item database\database.sqlite -ErrorAction SilentlyContinue
composer install
npm install
New-Item -ItemType File database\database.sqlite
php artisan key:generate
php artisan jwt:secret
php artisan migrate --seed
npm run build
php artisan optimize:clear
```

---

## Apéndice A — Linux / macOS

Los pasos son idénticos; solo cambian los comandos de sistema.

| Windows (PowerShell) | Linux / macOS |
|---|---|
| `Copy-Item .env.example .env` | `cp .env.example .env` |
| `New-Item -ItemType File database\database.sqlite` | `touch database/database.sqlite` |
| `curl.exe` | `curl` |
| `Select-String patrón` | `grep patrón` |
| `Remove-Item -Recurse -Force carpeta` | `rm -rf carpeta` |
| `php -m \| Select-String sodium` | `php -m \| grep sodium` |

### Instalar las extensiones de PHP

**Debian / Ubuntu:**
```bash
sudo apt install php8.3-cli php8.3-sqlite3 php8.3-mbstring php8.3-xml php8.3-curl php8.3-zip php8.3-sodium
```

**Arch:**
```bash
sudo pacman -S php php-sodium php-sqlite
# Habilitarlas si no quedaron activas:
grep -q '^extension=sodium' /etc/php/php.ini || echo 'extension=sodium' | sudo tee -a /etc/php/php.ini
grep -q '^extension=pdo_sqlite' /etc/php/php.ini || echo 'extension=pdo_sqlite' | sudo tee -a /etc/php/php.ini
php -m | grep -E 'sodium|sqlite'
```

**macOS (Homebrew):**
```bash
brew install php composer node
```

### Permisos

```bash
chmod -R 775 storage bootstrap/cache
```

---

## Apéndice B — Resumen copy-paste

Para alguien que **ya tiene** PHP (con las extensiones activas), Composer, Node y Git instalados:

```powershell
git clone https://github.com/Drayer-dm/techsolutiongroups.git
cd techsolutiongroups
git switch dev
composer install
npm install
Copy-Item .env.example .env
php artisan key:generate
php artisan jwt:secret
if (-not (Test-Path database\database.sqlite)) { New-Item -ItemType File database\database.sqlite }
php artisan migrate --seed
npm run build
composer run dev
```

Luego abrí 👉 **http://127.0.0.1:8000**
Ingresá con `test@example.com` / `password`.

---

## Notas finales

- **Nunca subas el `.env` al repositorio.** Contiene la `APP_KEY` y el `JWT_SECRET`, que son secretos por máquina. Ya está en el `.gitignore`.
- **Nunca subas `vendor/`, `node_modules/` ni `public/build/`.** Se regeneran con `composer install`, `npm install` y `npm run build`.
- **`database/database.sqlite` tampoco viaja en el repo** (`database/.gitignore` ignora `*.sqlite*`). Por eso el [paso 6](#paso-6--crear-el-archivo-de-la-base-de-datos) es obligatorio en cada máquina nueva, y por eso **la base de datos de cada integrante es independiente**: los datos que cargues vos no los ve el resto. Lo único compartido son las migraciones y los seeders.
- Ante cualquier comportamiento raro que no se explique por el código, el primer reflejo es `php artisan optimize:clear`.
