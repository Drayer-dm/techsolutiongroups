# Guía de instalación — Documentación Swagger (L5-Swagger) en TechSolutionGroups

> **Documento de instrucciones**, hermano de `GUIA-API-REST-TechSolutionGroups.md`. Mismo
> proyecto, mismo estilo, misma idea: la receta completa, con el código listo para copiar y
> los errores reales que salieron en el camino, para que nadie repita la misma vuelta.
>
> - **Proyecto:** `techsolutiongroups`
> - **Stack:** PHP 8.3 · Laravel 13 · `darkaonline/l5-swagger` (usa `zircote/swagger-php` por
>   debajo)
> - **Sintaxis usada:** **Atributos de PHP 8** (`#[OA\...]`), NO la de comentarios `@OA`
>   clásica — el porqué está en la [sección 1](#1-atributos-de-php-8-vs-docblocks-clásicos)
> - **Guía hermana:** `GUIA-API-REST-TechSolutionGroups.md`

---

## ⚠️ Antes que nada: revisen si ya llegó con el push

Antes de instalar nada a mano, chequeen si `composer.json` ya trae `darkaonline/l5-swagger`
en el `require`. Si es así:

```bash
composer install
php artisan l5-swagger:generate
php artisan serve
```

Y entren a `http://localhost:8000/api/documentation`. Si eso ya funciona, no necesitan leer
el resto de este documento — sáltense directo a la [sección 8](#8-solución-de-problemas) solo
si algo falla.

Si el paquete **no** aparece en `composer.json`, esta guía es para ustedes desde el
[Paso 1](#paso-1--instalar-el-paquete).

---

## 👥 Cómo quedó repartido

| Qué | Quién | Estado |
|---|---|---|
| Instalación del paquete + configuración | Pipe | ✅ Hecho |
| Anotaciones de `index()` y `store()` | Pipe (a partir del código de Drayer) | ✅ Hecho |
| Anotaciones de `show()` y `update()` | Pipe | ✅ Hecho |
| Anotación de `destroy()` | Luisa | ⏳ Pendiente |

El bloque de `destroy()` sigue exactamente el mismo patrón que `show()` — está detallado en
la [sección 3.7](#37-encima-de-destroy--le-toca-a-luisa).

---

## 📍 Estado actual del proyecto

### Terminado ✅

| Qué | Dónde | Quién |
|---|---|---|
| Paquete `darkaonline/l5-swagger` instalado | `composer.json` / `composer.lock` | Pipe |
| `config/l5-swagger.php` publicado | `config/l5-swagger.php` | Pipe |
| `use OpenApi\Attributes as OA;` | `app/Http/Controllers/Api/ProyectoController.php` | Pipe |
| `#[OA\Info(...)]` global | idem | Pipe |
| `#[OA\Get(...)]` en `index()` | idem | Pipe |
| `#[OA\Post(...)]` en `store()` | idem | Pipe |
| `#[OA\Get(...)]` en `show()` | idem | Pipe |
| `#[OA\Put(...)]` + `#[OA\Patch(...)]` en `update()` | idem | Pipe |
| UI probada en `/api/documentation` | — | Pipe |

### Pendiente ⏳

| Qué | Quién | Sección |
|---|---|---|
| `#[OA\Delete(...)]` en `destroy()` | Luisa | [3.7](#37-encima-de-destroy--le-toca-a-luisa) |
| Commit + push de todo lo anterior | Pipe (o quien instale) | [9](#9-después-de-instalar-avisar-al-equipo) |

---

## Índice

1. [Atributos de PHP 8 vs. docblocks clásicos](#1-atributos-de-php-8-vs-docblocks-clásicos)
2. [Paso 1 — Instalar el paquete](#paso-1--instalar-el-paquete)
3. [Paso 2 — Publicar la configuración](#paso-2--publicar-la-configuración)
4. [Paso 3 — Los bloques de atributos, completos](#paso-3--los-bloques-de-atributos-completos)
5. [Paso 4 — Generar la documentación](#paso-4--generar-la-documentación)
6. [Paso 5 — Ver la documentación en el navegador](#paso-5--ver-la-documentación-en-el-navegador)
7. [Checklist de autoevaluación](#checklist-de-autoevaluación)
8. [Solución de problemas](#8-solución-de-problemas)
9. [Después de instalar: avisar al equipo](#9-después-de-instalar-avisar-al-equipo)
10. [Apéndice — Referencia rápida de comandos](#apéndice--referencia-rápida-de-comandos)

---

## 1. Atributos de PHP 8 vs. docblocks clásicos

Existen dos formas históricas de escribir anotaciones para `swagger-php`:

1. **Docblocks clásicos** — `/** @OA\Info(...) */`. Requieren la dependencia
   `doctrine/annotations` instalada aparte para funcionar.
2. **Atributos nativos de PHP 8** — `#[OA\Info(...)]`. No requieren nada extra: el propio
   PHP los entiende como parte del lenguaje, desde PHP 8.0.

**Decidimos usar la opción 2** para no meter una dependencia más de la necesaria (ya
suficiente tenemos con `jwt-auth`) y porque, con PHP 8.3 en el proyecto, es la forma nativa y
recomendada por el propio mantenedor de `swagger-php`.

👉 **Consecuencia práctica:** en todo este documento, cuando hablamos de "anotar" un método,
nos referimos a poner `#[OA\...]` pegado arriba de la firma — nunca `/** @OA\... */`.

---

## Paso 1 — Instalar el paquete

Parados en la raíz del proyecto (donde está `composer.json`):

```bash
composer require darkaonline/l5-swagger
```

Esto trae `darkaonline/l5-swagger` y, como dependencia, `zircote/swagger-php` (el motor que
realmente lee los atributos y arma el JSON de OpenAPI).

## Paso 2 — Publicar la configuración

```bash
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
```

Esto genera dos cosas:

| Archivo | Para qué sirve |
|---|---|
| `config/l5-swagger.php` | Título de la doc, ruta de la UI (`/api/documentation` por defecto), y qué carpetas escanea buscando atributos (`app/` por defecto — ya cubre el controller) |
| `resources/views/vendor/l5-swagger/index.blade.php` | Plantilla de la UI. **No hay que tocarla.** |

---

## Paso 3 — Los bloques de atributos, completos

### 3.1. El `use` — arriba del archivo, junto a los demás

```php
use OpenApi\Attributes as OA;
```

⚠️ Tiene que decir **`Attributes`**, no `Annotations` — ver por qué en
[8.1](#81-required-oainfo-not-found).

### 3.2. Encima de `class ProyectoController` (global, una sola vez)

```php
#[OA\Info(
    version: "1.0.0",
    title: "API REST de proyectos",
    description: "API REST de proyectos para la Evaluación Sumativa Unidad 3"
)]
class ProyectoController extends Controller
```

### 3.3. Encima de `index()` — hecho (Pipe, sobre la base de Drayer)

```php
#[OA\Get(
    path: "/api/proyectos",
    summary: "Listar todos los proyectos",
    tags: ["Proyectos"],
    responses: [
        new OA\Response(response: 200, description: "Listado de proyectos obtenido correctamente")
    ]
)]
public function index(): JsonResponse
```

### 3.4. Encima de `store()` — hecho (Pipe, sobre la base de Drayer)

```php
#[OA\Post(
    path: "/api/proyectos",
    summary: "Crear un nuevo proyecto",
    tags: ["Proyectos"],
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["nombre", "fecha_inicio", "estado", "responsable", "monto", "created_by"],
            properties: [
                new OA\Property(property: "nombre", type: "string", example: "Cableado sucursal centro"),
                new OA\Property(property: "fecha_inicio", type: "string", format: "date", example: "2026-10-01"),
                new OA\Property(property: "estado", type: "string", example: "pendiente"),
                new OA\Property(property: "responsable", type: "string", example: "Drayer Yoncley"),
                new OA\Property(property: "monto", type: "integer", example: 1500000),
                new OA\Property(property: "created_by", type: "integer", example: 1),
            ]
        )
    ),
    responses: [
        new OA\Response(response: 201, description: "Proyecto creado correctamente"),
        new OA\Response(response: 422, description: "Campos inválidos"),
    ]
)]
public function store(Request $request): JsonResponse
```

### 3.5. Encima de `show()` — hecho (Pipe)

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

### 3.6. Encima de `update()` — hecho (Pipe) — dos atributos apilados

```php
#[OA\Put(
    path: "/api/proyectos/{id}",
    summary: "Actualizar un proyecto (reemplazo completo)",
    tags: ["Proyectos"],
    parameters: [
        new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
    ],
    requestBody: new OA\RequestBody(
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "estado", type: "string", example: "en_curso"),
                new OA\Property(property: "monto", type: "integer", example: 2000000),
            ]
        )
    ),
    responses: [
        new OA\Response(response: 200, description: "Proyecto actualizado correctamente"),
        new OA\Response(response: 404, description: "No existe un proyecto con ese id"),
        new OA\Response(response: 422, description: "Campos inválidos"),
    ]
)]
#[OA\Patch(
    path: "/api/proyectos/{id}",
    summary: "Actualizar un proyecto (parcial)",
    tags: ["Proyectos"],
    parameters: [
        new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
    ],
    requestBody: new OA\RequestBody(
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "estado", type: "string", example: "en_curso")
            ]
        )
    ),
    responses: [
        new OA\Response(response: 200, description: "Proyecto actualizado correctamente"),
        new OA\Response(response: 404, description: "No existe un proyecto con ese id"),
        new OA\Response(response: 422, description: "Campos inválidos"),
    ]
)]
public function update(Request $request, $id): JsonResponse
```

### 3.7. Encima de `destroy()` — le toca a **Luisa**

Mismo patrón que `show()`, cambiando el verbo y las responses (sin `422`, porque `destroy()`
no valida body):

```php
#[OA\Delete(
    path: "/api/proyectos/{id}",
    summary: "Eliminar un proyecto por su ID",
    tags: ["Proyectos"],
    parameters: [
        new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
    ],
    responses: [
        new OA\Response(response: 200, description: "Proyecto eliminado correctamente"),
        new OA\Response(response: 404, description: "No existe un proyecto con ese id"),
    ]
)]
public function destroy($id): JsonResponse
```

### 3.8. Si quieren mantener sus docblocks explicativos

No hay problema en tener ambos — el docblock normal (`/** */` con notas para humanos) va
**arriba** del atributo, nunca en medio de él:

```php
/**
 * REQUERIMIENTO 5 — Eliminar un proyecto por su ID.
 * (comentario normal, para humanos — swagger-php lo ignora)
 */
#[OA\Delete(
    ...
)]
public function destroy($id): JsonResponse
```

---

## Paso 4 — Generar la documentación

```bash
php artisan l5-swagger:generate
```

Señal de éxito: el mensaje `Regenerating docs default` **sin** ningún `ErrorException`
debajo. Genera `storage/api-docs/api-docs.json`.

> Cada vez que cambien una anotación hay que volver a correr este comando (o activar
> `L5_SWAGGER_GENERATE_ALWAYS=true` en `.env` para que se regenere solo en cada request,
> cómodo mientras están desarrollando).

## Paso 5 — Ver la documentación en el navegador

```bash
php artisan serve
```

Entrar a `http://localhost:8000/api/documentation`. Deberían ver los 5 endpoints agrupados
bajo el tag **"Proyectos"**, con colores por verbo (GET azul, POST verde, PUT naranja, PATCH
turquesa, DELETE rojo).

Para probar de verdad, no solo mirar: click en cualquier endpoint → **"Try it out"** →
completar parámetros/body → **"Execute"**. Deberían recibir la misma respuesta que ya
comprobaron en Postman.

---

## Checklist de autoevaluación

- [ ] `composer.json` tiene `darkaonline/l5-swagger`
- [ ] `config/l5-swagger.php` existe
- [ ] El `use` dice `OpenApi\Attributes as OA` (no `Annotations`)
- [ ] `#[OA\Info(...)]` está justo antes de `class ProyectoController`, sin `;` después del `)]`
- [ ] Los 5 métodos tienen su atributo correspondiente (4 hechos + `destroy()` de Luisa)
- [ ] `php artisan l5-swagger:generate` corre sin `ErrorException`
- [ ] `/api/documentation` muestra los 5 endpoints con sus responses correctos
- [ ] Se probó al menos un `Try it out` con éxito (200) y uno con error (404 o 422)

---

## 8. Solución de problemas

### 8.1. `Required @OA\Info() not found`

**Causa:** el `use` de arriba del archivo dice `use OpenApi\Annotations as OA;` en vez de
`use OpenApi\Attributes as OA;`. Compila sin error de sintaxis, pero `swagger-php` literalmente
no reconoce el atributo — para él es como si no existiera.

**Cómo confirmarlo:** si usan un linter tipo Intelephense, va a marcar en el panel de
"Problems":
```
Attempting to use non-attribute "OpenApi\Annotations\Info" as attribute.
```
Ese mensaje es la pista definitiva.

**Solución:** cambiar `Annotations` por `Attributes` en el `use`.

### 8.2. Error de sintaxis apuntando al `#[OA\Info(...)]`

**Causa más común:** quedó un `;` después del `)]` de cierre (por ejemplo `)];`). Un atributo
de PHP no es una instrucción normal — no lleva punto y coma, porque justo después PHP espera
la declaración de la clase o el método, no un statement vacío.

**Solución:** el atributo cierra en `)]` y ahí termina, sin nada más después.

### 8.3. `l5-swagger:generate` falla pero `php -l` dice que el archivo está bien

**Causa:** falta cerrar un array (`responses: [...]` o `parameters: [...]`) antes del `)]`
final del atributo completo. Es fácil que pase porque a veces sigue siendo sintácticamente
válido para PHP, solo arma mal el árbol de argumentos — por eso `php -l` no lo detecta.

Mal:
```php
    responses: [
        new OA\Response(response: 200, description: "...")
)]                                    // ← falta el ] del array antes de esto
```

Bien:
```php
    responses: [
        new OA\Response(response: 200, description: "...")
    ]                                 // cierra el array
)]                                    // cierra el atributo
```

**Cómo depurar:** si `php -l app/Http/Controllers/Api/ProyectoController.php` no marca nada
pero `l5-swagger:generate` sigue fallando, revisen los corchetes de los arrays uno por uno
antes que cualquier otra cosa.

### 8.4. Warning de `mysqli` al correr los comandos de `artisan`

```
PHP Warning:  Module "mysqli" is already loaded in Unknown on line 0
```

No tiene nada que ver con Swagger — es que el módulo `mysqli` está cargado dos veces en el
`php.ini` de su entorno local (típico en instalaciones tipo XAMPP con configuración
duplicada). Es solo ruido, se puede ignorar sin problema.

---

## 9. Después de instalar: avisar al equipo

Si son ustedes quienes terminan instalando (porque el push de Pipe no llegó a tiempo), al
correr `composer require` se modifican `composer.json` **y** `composer.lock`. Al pushear:

- El resto del equipo tiene que correr `composer install` (no `composer update`) después de
  hacer `pull`, para que su `vendor/` quede sincronizado con el `composer.lock` exacto que
  subieron.
- Si alguien más también instaló Swagger por su cuenta en paralelo, va a haber conflicto en
  `composer.lock` al mergear — en ese caso, quédense con una sola versión del archivo (borrar
  la propia, correr `composer install` de nuevo, y commitear el que se regenera solo) en vez
  de intentar resolver el conflicto línea por línea a mano.

---

## Apéndice — Referencia rápida de comandos

```bash
# Instalar
composer require darkaonline/l5-swagger

# Publicar configuración (una sola vez)
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"

# Regenerar la documentación (cada vez que cambien un atributo)
php artisan l5-swagger:generate

# Ver en el navegador
php artisan serve
# → http://localhost:8000/api/documentation

# Lint rápido si algo no compila
php -l app/Http/Controllers/Api/ProyectoController.php
```

---

*Guía escrita a partir de la implementación real hecha por Pipe con ayuda de Claude (mi hombre de los MD),
documentando también los tres errores que salieron en el camino para que Drayer y Luisa no
los repitan si les toca instalar de cero.*