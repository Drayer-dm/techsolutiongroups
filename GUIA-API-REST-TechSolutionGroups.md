# Guía de implementación — API REST de Proyectos (Evaluación Sumativa U3)

> **Documento de instrucciones.** Reescrito el 2026-09-04 para que coincida **exactamente** con
> lo que piden `Evaluación de desarrollo o entrega_código.pdf` y `Rúbrica_U3.pdf`.
>
> **Este archivo no ejecuta nada.** Es la receta paso a paso, con el código completo y comentado.
>
> - **Proyecto:** `/home/drayer/Proyectos/techsolutiongroups`
> - **Stack:** PHP 8.5.10 · Laravel 13.25.0 · SQLite · `php-open-source-saver/jwt-auth 2.9.2`
> - **Guía hermana:** `techsolutiongroups/GUIA-INSTALACION-TechSolutionGroups.md`

---

## ⚠️ Lo primero: el alcance es MUCHO más chico de lo que parecía

La versión anterior de este documento planteaba 21 endpoints (auth JWT, usuarios, productos,
CORS, versionado, rate limiting…). **Nada de eso se evalúa.**

La rúbrica tiene **4 indicadores y 100 puntos**, y los 4 son sobre **una sola tabla: `proyectos`**.

| Lo que se evalúa | Puntos |
|---|---|
| Insertar (POST) | 26 |
| Recuperar (GET todos + GET por id) | 26 |
| Actualizar (PUT/PATCH) | 24 |
| Eliminar (DELETE) | 24 |
| **Total** | **100** |

**Lo que NO aparece en ninguno de los dos PDF:** autenticación, JWT, tokens, usuarios,
productos, paginación, filtros, CORS, versionado `/v1/`, rate limiting, API Resources,
Policies, tests automatizados.

👉 **Resultado práctico: el trabajo se resuelve creando 1 archivo y agregando 6 líneas de rutas.**
Todo lo demás de este documento es o bien verificación, o bien mejoras opcionales claramente
marcadas como tales.

---

## 👥 Cómo está repartido y con qué estilo se escribe

**Tres decisiones del equipo que atraviesan todo el documento.** Si venís de una versión
anterior de esta guía, leé esto antes que nada.

### 1. El controlador lo escriben tres personas

| Persona | Qué le toca | Estado |
|---|---|---|
| **Drayer** | Pasos 1 y 2 · esqueleto del controlador · `index()` · `store()` · sus 2 rutas | ✅ **Hecho y probado** |
| **Pipe** | `show()` · `update()` | ✅ **Hecho y probado** |
| **Luisa** | `destroy()` · completar `routes/api.php` · Paso 5 · entrega | ⏳ Pendiente |

El detalle, el orden de merge y los commits sugeridos están en
[Cómo repartir el trabajo](#cómo-repartir-el-trabajo).

### 2. Estilo clásico y explícito, no idiomático

Los 5 métodos devuelven **el mismo envoltorio JSON** — `ok`, `codigo`, `endpoint`, `mensaje`,
`data` — y todo el manejo de errores está **escrito a mano** en el controlador:

- códigos numéricos literales (`200`, `201`, `404`, `422`), no `Response::HTTP_OK`;
- `Proyecto::find($id)` + `if`, no route model binding;
- `Validator::make()` + `if ($validador->fails())`, no `$request->validate()`;
- rutas escritas una por una, no `Route::apiResource()`.

Es más código, pero cada decisión queda a la vista y se puede defender en la evaluación. El
contrato completo está en [3.0](#30-estilo-de-las-respuestas--leer-antes-de-escribir-código),
**incluidos los dos puntos donde nos apartamos a propósito de la letra del PDF** (`index()` con
la tabla vacía y `destroy()` con 200 en vez de 204).

### 3. Los mensajes salen de `lang/`, no del controlador

La aplicación responde en **español o inglés** según el navegador. Ningún método escribe textos
de error a mano: salen de `lang/es/validation.php` y `lang/en/validation.php`, y un middleware
elige el idioma en cada petición.

👉 **Pipe y Luisa: lean la [sección 7](#7-los-mensajes-en-dos-idiomas--es--en) antes de escribir
su método.** Es corta y les evita el error de pasarle un tercer argumento a `Validator::make()`.

---

## 📍 Estado actual del proyecto

Esto es lo que hay **hoy** en el repositorio, para que nadie repita trabajo hecho ni arranque
sobre algo que todavía no existe.

### Terminado ✅

| Qué | Dónde | Quién |
|---|---|---|
| `Proyecto::ESTADOS` como constante pública | `app/Models/Proyecto.php` | Drayer |
| Controlador web usando `Proyecto::ESTADOS` | `app/Http/Controllers/ProyectoController.php` | Drayer |
| Validaciones nuevas en el alta web (`min:5`, fecha ≥ 2010) | idem | Drayer |
| Esqueleto de `Api/ProyectoController` con los 5 métodos | `app/Http/Controllers/Api/ProyectoController.php` | Drayer |
| `index()` — GET /api/proyectos → 200 | idem | Drayer |
| `store()` — POST /api/proyectos → 201 · 422 | idem | Drayer |
| Sistema de idiomas es/en completo | `lang/`, `app/Http/Middleware/SetLocale.php`, `config/app.php`, `bootstrap/app.php` | Drayer |
| Las 2 rutas de Drayer | `routes/api.php` | Drayer |

### Pendiente ⏳

| Qué | Quién | Paso |
|---|---|---|
| `show()` — reemplazar el 501 provisorio | Pipe | [3.2](#32-contenido-completo) |
| `update()` — reemplazar el 501 provisorio | Pipe | [3.2](#32-contenido-completo) |
| `destroy()` — reemplazar el 501 provisorio | Luisa | [3.2](#32-contenido-completo) |
| Las 4 rutas que faltan | Luisa | [Paso 4](#paso-4--registrar-las-rutas) |
| 404 de rutas inexistentes (opcional) | Luisa | [Paso 5](#paso-5--404-de-rutas-inexistentes-opcional) |
| Colección de Postman, `LEEME-API.md`, ZIP | Luisa | [Formato de entrega](#formato-de-entrega) |

### Los 3 métodos pendientes ya responden algo

No están vacíos: devuelven un **501 Not Implemented** con el envoltorio completo.

```json
{
    "ok": false,
    "codigo": 501,
    "endpoint": "GET /api/proyectos/7",
    "mensaje": "Endpoint todavía no implementado.",
    "data": null
}
```

Eso hace dos cosas: el archivo **compila** aunque falten métodos, y si alguien prueba un
endpoint sin terminar ve un mensaje claro en vez de un error de PHP. Pipe y Luisa solo tienen
que **reemplazar el cuerpo** de su método; la firma y el docblock ya están.

### Cómo levantar el proyecto hoy

```bash
composer install
npm install
npm run build          # ⚠️ IMPRESCINDIBLE: sin esto la web tira 500
php artisan serve
```

> **El `npm run build` no es opcional.** Las vistas usan `@vite(...)` y `public/build/` está en
> `.gitignore`, así que no viene en el repositorio. Si te salteás ese paso, **todas** las
> páginas web devuelven `500 ViteManifestNotFoundException` — la API funciona igual, pero vas a
> creer que rompiste algo. Alternativa para desarrollo: `npm run dev` en otra terminal.

### Usuarios que existen hoy (para `created_by`)

| id | nombre | correo |
|---|---|---|
| 1 | Test User | test@example.com |
| 2 | carlo | drayer11@gmail.com |
| 3 | Drayer | drayeryoncley11@gmail.com |

Cualquier otro id da **422** por la regla `exists:usuarios,id`.

---

## Índice

1. [Qué piden exactamente (extracto de los PDF)](#1-qué-piden-exactamente-extracto-de-los-pdf)
2. [Cómo se puntúa (la rúbrica traducida)](#2-cómo-se-puntúa-la-rúbrica-traducida)
3. [La contradicción del enunciado en PUT/PATCH](#3-la-contradicción-del-enunciado-en-putpatch)
4. [Diagnóstico: qué ya tenés y qué falta](#4-diagnóstico-qué-ya-tenés-y-qué-falta)
5. [Decisión clave: ¿la API lleva token o no?](#5-decisión-clave-la-api-lleva-token-o-no)
6. [Mapa de archivos: qué va dónde](#6-mapa-de-archivos-qué-va-dónde)
7. [Los mensajes en dos idiomas — es / en](#7-los-mensajes-en-dos-idiomas--es--en) 🆕
8. [Paso 1 — Preparar la rama](#paso-1--preparar-la-rama)
9. [Paso 2 — Mover la lista de estados al modelo](#paso-2--mover-la-lista-de-estados-al-modelo)
10. [Paso 3 — `Api/ProyectoController` (el archivo central)](#paso-3--apiproyectocontroller-el-archivo-central)
11. [Paso 4 — Registrar las rutas](#paso-4--registrar-las-rutas)
12. [Paso 5 — 404 de rutas inexistentes (opcional)](#paso-5--404-de-rutas-inexistentes-opcional)
13. [Paso 6 — Probar los 4 indicadores de la rúbrica](#paso-6--probar-los-4-indicadores-de-la-rúbrica)
14. [Checklist de autoevaluación (puntaje esperado)](#checklist-de-autoevaluación-puntaje-esperado)
15. [Formato de entrega](#formato-de-entrega)
16. [Cómo repartir el trabajo](#cómo-repartir-el-trabajo)
17. [Solución de problemas](#solución-de-problemas)
18. [Apéndice A — Mejoras opcionales (fuera de rúbrica)](#apéndice-a--mejoras-opcionales-fuera-de-rúbrica)
19. [Apéndice B — Referencia rápida de la API](#apéndice-b--referencia-rápida-de-la-api)

> Antes del índice: [👥 Cómo está repartido](#-cómo-está-repartido-y-con-qué-estilo-se-escribe)
> y [📍 Estado actual del proyecto](#-estado-actual-del-proyecto). **Empiecen por ahí.**

---

## 1. Qué piden exactamente (extracto de los PDF)

### Contexto del caso

> *"La empresa Tech Solutions ha decidido modernizar su sistema de gestión de proyectos. El
> esqueleto y base de los controladores fue creado como parte de la Unidad 1 y los modelos
> fueron creados como parte de la unidad 2, ahora debemos trabajar en los requerimientos…"*

Traducido: **los modelos y los controladores ya existen** (y de hecho existen: `Proyecto`,
`Usuario`, `ProyectoController`, `UsuarioController`). Lo único que falta es **la lógica CRUD
expuesta por HTTP**.

### Los 5 requerimientos, textuales

| # | Requerimiento | Reglas literales del PDF |
|---|---|---|
| **1** | **Agregar** un proyecto por **POST** | · Todos los campos son requeridos y no deben estar vacíos<br>· El código de respuesta debe ser **201** |
| **2** | **Buscar todos** los proyectos por **GET** | · La respuesta debe incluir **todos los campos**<br>· Si no hay registros debe retornar **un arreglo vacío**<br>· El código de respuesta debe ser **200** |
| **3** | **Buscar uno** por su **ID** por **GET** | · Si el Id no existe debe retornar **404**<br>· La respuesta debe incluir todos los campos<br>· El código de respuesta debe ser **200** |
| **4** | **Actualizar** por su ID por **PATCH o PUT** | · Si el Id no existe debe retornar **404**<br>· La respuesta debe incluir todos los campos actualizados<br>· El código de respuesta debe ser **200** ⚠️ (ver [§3](#3-la-contradicción-del-enunciado-en-putpatch)) |
| **5** | **Eliminar** por su ID por **DELETE** | · Si el Id no existe debe retornar **404**<br>· La respuesta debe ser **vacía**<br>· El código de respuesta debe ser **204** |

### Tres detalles del enunciado que hay que leer con lupa

**a) "Todos los campos son requeridos y no deben estar vacíos".**
Los campos de la tabla `proyectos` (según `2026_08_07_171926_create_proyectos_table.php`) son:
`nombre`, `fecha_inicio`, `estado`, `responsable`, `monto` y `created_by`.
**Los seis** tienen que ser obligatorios en el POST — incluido `created_by`, que hoy el
controlador web rellena solo desde la sesión. Si dejás alguno fuera de la validación, caés en
*"carencia de las validaciones"* → **18 pts en vez de 26**.

**b) "Debe retornar un arreglo vacío".**
Literal: `[]`, no `{"data": []}`. Por eso **no vamos a usar API Resources** — devolvemos la
colección de Eloquent directo, que además garantiza el *"la respuesta debe incluir todos los
campos"*.

**c) "La respuesta debe ser vacía" en el DELETE.**
`204 No Content` con **cero bytes** de cuerpo. Nada de `{"message": "eliminado"}`.

> ⚠️ **b) y c) son justamente los dos puntos donde el equipo decidió apartarse del PDF**, para
> que todas las respuestas lleven un mensaje legible. Es una decisión tomada a conciencia, no un
> descuido: está documentada, es reversible en una línea cada una, y el riesgo de puntaje está
> escrito. Antes de entregar, **pregúntenle al profesor si acepta el envoltorio** — es lo único
> que puede costar puntos y se resuelve con un correo.
> Ver [3.0](#30-estilo-de-las-respuestas--leer-antes-de-escribir-código).

### ¿El CRUD tiene que ser sobre `proyectos`, o es solo porque el modelo ya existe?

**Es un requisito explícito, no una conveniencia.** Se verificó contando las apariciones en
los dos PDF:

| | "proyecto/s" | usuarios | productos | clientes |
|---|---|---|---|---|
| `Rúbrica_U3.pdf` | **16** | 0 | 0 | 0 |
| `Evaluación de desarrollo o entrega_código.pdf` | **9** | 0 | 0 | 0 |

Las 16 de la rúbrica salen de sus 4 indicadores × 4 niveles de desempeño: **cada una de las 16
celdas** repite la fórmula *"…utilización de controlador para poder **agregar / buscar /
actualizar / eliminar un proyecto** en la Base de Datos…"*. No dice "un registro" ni "un
recurso": dice **un proyecto**, siempre.

> La única aparición de la palabra "producto" en el enunciado es *"la entrega de **un producto**
> que deberá cargar a la plataforma"* — se refiere al entregable, no a una tabla.

**Que el modelo ya exista no es casualidad, es el diseño del ramo.** El caso de estudio se
titula *"Desarrollo Software de Gestión de Proyectos"* y el propio enunciado aclara: *"El
esqueleto y base de los controladores fue creado como parte de la **Unidad 1** y los modelos
fueron creados como parte de la **Unidad 2**, ahora debemos trabajar en los requerimientos…"*.
La U3 es el capítulo donde a esa misma tabla se le pone el CRUD por HTTP.

**Consecuencias prácticas:**

- Hacer el CRUD sobre `usuarios` o `productos` **en vez de** `proyectos` **no suma puntos**: la
  rúbrica no tiene dónde anotarlos.
- Hacerlo **además de** `proyectos` tampoco suma, y cada archivo extra es una chance más de
  romper algo que sí puntúa. Ver [Apéndice A](#apéndice-a--mejoras-opcionales-fuera-de-rúbrica).

---

## 2. Cómo se puntúa (la rúbrica traducida)

Los 4 indicadores tienen la **misma estructura de niveles**. Esto es lo importante:

| Nivel | Puntos (POST/GET) | Puntos (PUT/DELETE) | Qué te deja ahí |
|---|---|---|---|
| **Bajo** | 0 | 0 | No se evidencia el uso del controlador |
| **Medio** | 18 | 15 | Usa el controlador **pero con errores de ejecución o carencia de las validaciones** |
| **Alto** | 22 | 21 | Funciona y valida, pero **sin el código de respuesta HTTP correcto** |
| **Sobresaliente** | 26 | 24 | Funciona, valida **y con el código de respuesta HTTP correcto** |

### 🎯 Las dos únicas cosas que separan 66 puntos de 100

Leyendo los saltos de nivel, todo el puntaje se juega en dos ejes:

1. **Validaciones presentes** → es el salto de *Medio* a *Alto* (+4 y +6 puntos por indicador).
2. **Código HTTP exacto** → es el salto de *Alto* a *Sobresaliente* (+4 y +3 puntos por indicador).

**Por eso este documento insiste tanto en `201`, `200` y `404`.** No es purismo REST:
son literalmente **14 puntos** de la nota.

| Endpoint | Código que devolvemos | Lo que pedía el PDF | Error típico que cuesta puntos |
|---|---|---|---|
| POST | **201** | 201 | Devolver `200` (es lo que hace `response()->json()` sin segundo argumento) |
| GET todos | **200** | 200 | ✅ Difícil de errar |
| GET uno | **200** / **404** | igual | Devolver `500` porque no se manejó el id inexistente |
| PUT/PATCH | **200** / **404** | igual | Devolver `204`, o `500` por id inexistente |
| DELETE | **200** con mensaje | **204** vacío | — *(desvío consciente, ver abajo)* |

> ⚠️ **El `DELETE` es el único código donde nos apartamos del PDF a propósito**, para poder
> devolver un mensaje de confirmación legible. Un `204` no lleva cuerpo por definición, así que
> "204 + mensaje" no existe: hay que elegir uno. La decisión, el riesgo y cómo revertirla en una
> línea están en [3.0](#30-estilo-de-las-respuestas--leer-antes-de-escribir-código).

---

## 3. La contradicción del enunciado en PUT/PATCH

El PDF **se contradice a sí mismo** en el requerimiento 4:

> *"Actualizar un proyecto por medio de su ID por medio de método HTTP PATCH o PUT con **una
> respuesta HTTP de 201** con los siguientes requerimientos: […] El **codigo de respuesta debe
> ser 200**."*

Dice **201** en la línea de encabezado y **200** en la viñeta.

### Qué hacer

**Devolvé `200`.** Razones:

1. La viñeta es más específica que el encabezado, y es donde el PDF lista las reglas puntuales
   de cada endpoint (el mismo patrón se repite en los otros 4 requerimientos).
2. `201 Created` significa *"se creó un recurso nuevo"*. Un UPDATE no crea nada, así que `200 OK`
   es lo correcto según el estándar HTTP. Un evaluador que sepa REST espera `200`.
3. El mismo encabezado del requerimiento 5 dice *"con una respuesta HTTP de 204"* y la viñeta
   también dice 204 → cuando coinciden, el encabezado es descriptivo. Acá no coinciden, y la
   viñeta gana.

### Cómo cubrirte igual

En el controlador te dejo la línea del código de estado **aislada y comentada**, para que
puedas cambiarla en 2 segundos si el profesor aclara que quiere `201`:

```php
    'codigo'   => 200,        // ← si el profe aclara que quiere 201, cambiá estos
    ...
], 200);                      // ← dos números y listo
```

**Y preguntale por el foro/correo antes de entregar.** Es la única ambigüedad real del enunciado
y vale 24 puntos.

---

## 4. Diagnóstico: qué ya tenés y qué falta

### 4.1. Ya está listo ✅ (no hay que tocarlo)

| Requisito | Dónde está | Estado |
|---|---|---|
| Modelo `Proyecto` | `app/Models/Proyecto.php` | ✅ Con `$fillable`, `$casts` y relación `creador()` |
| Modelo `Usuario` | `app/Models/Usuario.php` | ✅ |
| Tabla `proyectos` | `database/migrations/2026_08_07_171926_*` | ✅ Migrada |
| Base de datos | `database/database.sqlite` | ✅ Con 2 usuarios (ids 1 y 2) |
| `routes/api.php` cargado | `bootstrap/app.php` → `withRouting(api: …)` | ✅ Prefijo `/api` automático |
| Respuestas JSON en `/api/*` | `bootstrap/app.php` → `shouldRenderJsonWhen` | ✅ **Clave**: hace que los errores de validación salgan como JSON 422 y no como redirect HTML |
| CRUD de referencia | `app/Http/Controllers/ProyectoController.php` (web) | ✅ Sirve de modelo: ya tiene las reglas de validación |

> **Nota importante:** la línea `shouldRenderJsonWhen(fn ($request) => $request->is('api/*'))`
> que ya está en `bootstrap/app.php` es la que hace que todo esto funcione sin configurar nada
> más. **No la borres.**

### 4.2. Falta ❌

| Qué falta | Archivo | Paso | Quién |
|---|---|---|---|
| Lista de estados accesible desde la API | `app/Models/Proyecto.php` | [2](#paso-2--mover-la-lista-de-estados-al-modelo) | Drayer |
| Esqueleto del controlador + `index()` + `store()` | `app/Http/Controllers/Api/ProyectoController.php` | [3](#paso-3--apiproyectocontroller-el-archivo-central) | Drayer |
| `show()` + `update()` | *(el mismo archivo)* | [3](#paso-3--apiproyectocontroller-el-archivo-central) | Pipe |
| `destroy()` | *(el mismo archivo)* | [3](#paso-3--apiproyectocontroller-el-archivo-central) | Luisa |
| Las 6 rutas | `routes/api.php` | [4](#paso-4--registrar-las-rutas) | Luisa |

### 4.3. Dos cosas que encontré de paso (no son parte de la evaluación)

**a) `JwtMiddleware.php` — revertido al estado commiteado.** Había una modificación sin
commitear que agregaba `Auth::shouldUse('api')` y corregía el formato de las respuestas. **Se
descartó** (`git checkout --`) para dejar el árbol de trabajo limpio antes de empezar la U3.

> 🔧 **Corrección de una afirmación anterior de esta guía.** Una versión previa decía que sin
> `Auth::shouldUse('api')` la llamada `$request->user()` devuelve `null` en las rutas de API.
> **Eso es falso**, y se comprobó levantando el servidor y probando las dos versiones del
> archivo contra `/api/me`:
>
> | Prueba | Versión commiteada | Versión modificada |
> |---|---|---|
> | Sin token | `401` | `401` |
> | Token inválido | `401` | `401` |
> | Token válido | `200` + usuario | `200` + usuario |
> | `$request->user()` | ✅ el usuario | ✅ el usuario |
>
> El motivo es que `JWTAuth::parseToken()->authenticate()` termina llamando a
> `onceUsingId($id)` sobre el guard por defecto (ver
> `vendor/php-open-source-saver/jwt-auth/src/Providers/Auth/Illuminate.php`), y eso ya deja el
> usuario resuelto para la petición actual sin necesidad de sesión. `Auth::shouldUse('api')`
> cambia cuál es el guard por defecto, pero **no** es lo que hace que `$request->user()`
> funcione.
>
> **Las dos versiones son funcionales.** La modificada tenía tres mejoras de estilo (el
> namespace `JWTauth` bien escrito como `JWTAuth`, los códigos `401` como entero en vez de
> string, y la clave `message` unificada), pero ninguna arreglaba un bug real, y la evaluación
> de la U3 no usa este middleware. Si algún día querés aplicarlas, están detalladas en
> [A.8](#a8-mejoras-pendientes-en-jwtmiddleware-opcional).

**b) Ruta duplicada en `routes/web.php`.** `GET /ingreso` está definida dos veces dentro del
grupo `guest`: primero a `SessionController@create` y después a un closure. **Gana la segunda**
y anula al controlador. Funciona por casualidad porque devuelve la misma vista. Conviene borrar
el closure, pero no afecta la nota de esta unidad.

---

## 5. Decisión clave: ¿la API lleva token o no?

Esta es **la única decisión de diseño que tenés que tomar**, y afecta directamente la nota.

### El problema

El proyecto ya tiene JWT montado (`jwt.custom`, guard `api`, `Usuario implements JWTSubject`).
La tentación es proteger el CRUD con ese middleware. **No lo hagas para la entrega.**

### Comparación

| | **Opción A — API abierta** ✅ RECOMENDADA | **Opción B — API con JWT** |
|---|---|---|
| El evaluador prueba… | Abre Postman, manda POST, listo | Necesita hacer login, copiar el token, configurar el header |
| Si algo del token falla… | — | Recibe **401** en vez de **201** → *"código de respuesta incorrecto"* → **pierde 14 pts** |
| ¿Lo pide la rúbrica? | No lo menciona | No lo menciona |
| `created_by` sale de… | El body de la petición (validado con `exists`) | El token |
| Riesgo | Bajo | **Alto** |

### Por qué la Opción A también es más fiel al enunciado

El PDF dice *"Todos los campos son requeridos y no deben estar vacíos"*. Con JWT, `created_by`
y `responsable` los pondría el servidor desde el token, o sea **no serían campos requeridos del
request** — estarías contradiciendo el requisito 1 literal.

Con la API abierta, los 6 campos viajan en el body y los 6 se validan. Cumple al pie de la letra.

### Cómo blindarte igual

En el [Paso 4](#paso-4--registrar-las-rutas) te dejo la línea del middleware JWT **escrita y
comentada**. Si el profesor pregunta *"¿y la seguridad?"*, la respuesta es:

> *"El middleware JWT ya está implementado y probado en el proyecto (`jwt.custom`, con
> `/api/me` funcionando). Protegerlo es descomentar una línea. Lo dejé abierto porque el
> enunciado de la U3 pide que los 6 campos sean requeridos en el request, y con el token
> `created_by` vendría del servidor."*

Eso demuestra que **sabés** hacerlo y que la decisión fue deliberada.

---

## 6. Mapa de archivos: qué va dónde

### 6.1. El árbol completo, con lo que se toca marcado

```
techsolutiongroups/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   ├── RegisterController.php          ·  no se toca
│   │   │   │   └── SessionController.php           ·  no se toca
│   │   │   ├── Api/                                🆕 CARPETA NUEVA (la crea artisan)
│   │   │   │   └── ProyectoController.php          🆕 CREAR  ← el 100% de la nota
│   │   │   ├── Controller.php                      ·  no se toca
│   │   │   ├── ProyectoController.php              ✏️  5 reemplazos (self:: → Proyecto::)
│   │   │   ├── ServiceProjectController.php        ·  no se toca
│   │   │   └── UsuarioController.php               ·  no se toca (queda vacío, ver 6.5)
│   │   └── Middleware/
│   │       └── JwtMiddleware.php                   ·  no se toca (revertido, ver 4.3.a)
│   ├── Models/
│   │   ├── Proyecto.php                            ✏️  +12 líneas (constante ESTADOS)
│   │   └── Usuario.php                             ·  no se toca
│   └── Providers/AppServiceProvider.php            ·  no se toca
│
├── bootstrap/
│   └── app.php                                     ✏️  +9 líneas (OPCIONAL: 404 limpio)
│
├── config/                                         ·  NADA que tocar acá
├── database/
│   ├── migrations/                                 ·  NADA: la tabla ya existe
│   └── seeders/                                    ·  NADA: ya hay 2 usuarios
├── resources/views/                                ·  NADA: la API no tiene vistas
│
└── routes/
    ├── api.php                                     ✏️  +2 líneas (la ruta del CRUD)
    └── web.php                                     ·  no se toca
```

### 6.2. Tabla resumen — 1 archivo nuevo, 3 modificados

| # | Archivo | Acción | Dónde exactamente | Cómo se crea | Paso | Quién |
|---|---|---|---|---|---|---|
| 1 | `app/Models/Proyecto.php` | ✏️ Modificar | Insertar en la **línea 10**, justo después de `{` | A mano | [2](#paso-2--mover-la-lista-de-estados-al-modelo) | Drayer |
| 2 | `app/Http/Controllers/ProyectoController.php` | ✏️ Modificar | Borrar **líneas 18-23**; cambiar **31, 44, 69, 76** | A mano | [2](#paso-2--mover-la-lista-de-estados-al-modelo) | Drayer |
| 3 | `app/Http/Controllers/Api/ProyectoController.php` | 🆕 **Crear** | Carpeta nueva `Api/` | `php artisan make:controller` | [3](#paso-3--apiproyectocontroller-el-archivo-central) | los 3 |
| 4 | `routes/api.php` | ✏️ Modificar | Agregar `use` arriba + las 6 rutas al final | A mano | [4](#paso-4--registrar-las-rutas) | Luisa |
| 5 | `bootstrap/app.php` | ✏️ Modificar | `withMiddleware` (idiomas) + `withExceptions` (404 opcional) | A mano | [7](#7-los-mensajes-en-dos-idiomas--es--en) y [5](#paso-5--404-de-rutas-inexistentes-opcional) | Drayer ✅ / Luisa |

> El archivo **3 lo escriben los tres**, cada uno métodos distintos. Quién hace qué está en
> [Cómo repartir el trabajo](#cómo-repartir-el-trabajo).

**Archivos del sistema de idiomas** (ya hechos, ver [sección 7](#7-los-mensajes-en-dos-idiomas--es--en)):

| # | Archivo | Acción | Qué lleva |
|---|---|---|---|
| 6 | `lang/es/validation.php` | 🆕 Crear | 137 mensajes del validador + `custom` + `attributes` |
| 7 | `lang/es/{auth,passwords,pagination}.php` | 🆕 Crear | El resto de los textos de Laravel |
| 8 | `lang/en/*` | 🆕 Publicar | `php artisan lang:publish` los saca de `vendor/` |
| 9 | `lang/en.json` | 🆕 Crear | Las frases de nuestro código, las de `__()` |
| 10 | `app/Http/Middleware/SetLocale.php` | 🆕 Crear | Elige el idioma en cada petición |
| 11 | `config/app.php` | ✏️ Modificar | `'supported_locales' => ['es', 'en']` |

**Cero migraciones. Cero paquetes de Composer. Cero cambios en las vistas ni en el flujo web.**

### 6.3. La carpeta `app/Http/Controllers/Api/` todavía no existe

Antes de empezar, `app/Http/Controllers/` solo tenía la subcarpeta `Auth/`. **No la crees a
mano:** el comando del [Paso 3](#paso-3--apiproyectocontroller-el-archivo-central) la crea
solo. (Si ya corriste el comando, la carpeta y el archivo ya están: seguí desde
[3.2](#32-contenido-completo).)

```bash
php artisan make:controller Api/ProyectoController --api --model=Proyecto
```

La barra `/` en `Api/ProyectoController` es lo que le dice a Artisan *"metelo en una subcarpeta
llamada `Api`"*. El resultado:

```
app/Http/Controllers/Api/ProyectoController.php   ← archivo creado
                     ↑
                     carpeta creada automáticamente
```

**Y el namespace se ajusta solo.** Laravel usa PSR-4: la carpeta `app/` corresponde al namespace
`App\`, así que la ruta del archivo se traduce letra por letra al namespace de la clase:

```
app / Http / Controllers / Api / ProyectoController.php
App \ Http \ Controllers \ Api \ ProyectoController
```

Por eso el archivo generado arranca con:

```php
namespace App\Http\Controllers\Api;      // ← lo pone artisan, no lo cambies
```

Si movés el archivo de carpeta a mano, **tenés que cambiar el `namespace` a mano también**, o
PHP no lo encuentra (`Class not found`).

### 6.4. ¿Por qué una subcarpeta y no al lado del otro?

Porque van a existir **dos clases con el mismo nombre**:

| Archivo | Clase completa | Qué devuelve |
|---|---|---|
| `Controllers/ProyectoController.php` | `App\Http\Controllers\ProyectoController` | `view()` y `redirect()` — es el de la web |
| `Controllers/Api/ProyectoController.php` | `App\Http\Controllers\Api\ProyectoController` | `response()->json()` — es el de la API |

**Pueden convivir sin chocar porque el namespace es distinto.** Es la convención estándar de
Laravel para separar API de web, y le deja claro a cualquiera que lea el proyecto cuál es cuál.

⚠️ **La consecuencia práctica:** en `routes/api.php` el `use` tiene que apuntar al de `Api\`. Es
el error más fácil de cometer, porque los dos se llaman igual y el editor te autocompleta el
equivocado:

```php
use App\Http\Controllers\Api\ProyectoController;   // ✅ el nuevo, devuelve JSON
use App\Http\Controllers\ProyectoController;        // ❌ el de la web, devuelve redirects
```

### 6.5. Qué NO hay que tocar (y por qué)

| Archivo / carpeta | Por qué se deja quieto |
|---|---|
| `database/migrations/` | La tabla `proyectos` ya existe con sus 6 campos y la FK. **No hay nada que migrar.** |
| `database/seeders/` | Ya hay 2 usuarios (ids **1** y **2**) para usar en `created_by`. |
| `resources/views/` | Una API no devuelve HTML. |
| `config/` | El guard `api` ya está en `config/auth.php` y la U3 no usa JWT. |
| `app/Models/Usuario.php` | No se modifica: la API solo lee su `id` a través de la regla `exists`. |
| `app/Http/Controllers/UsuarioController.php` | Tiene los 7 métodos vacíos desde la U1. **Dejalo así**: ninguna ruta lo usa y la rúbrica no lo evalúa. Borrarlo también es válido (`git rm`), pero es cambio innecesario. |
| `app/Http/Middleware/JwtMiddleware.php` | Funciona y no interviene en el CRUD evaluado (ver [4.3.a](#43-dos-cosas-que-encontré-de-paso-no-son-parte-de-la-evaluación)). |
| `routes/web.php` | El flujo web de proyectos sigue funcionando igual, en paralelo a la API. |

### 6.6. Los 4 puntos de inserción, con línea exacta

Para que no tengas que buscar. Los números son del estado actual del repo (commit `d1a04db`).

**① `app/Models/Proyecto.php` → insertar en la línea 10**

```php
 8  class Proyecto extends Model
 9  {
10  ← ⬅️ ACÁ va la constante ESTADOS (Paso 2.1)
11      /**
12       * Tabla asociada al modelo.
13       */
14      protected $table = 'proyectos';
```

**② `app/Http/Controllers/ProyectoController.php` → borrar 18-23, cambiar 31 / 44 / 69 / 76**

```php
18      private const ESTADOS = [          ⬅️ ❌ BORRAR estas 6 líneas (18 a 23)
19          'pendiente'  => 'Pendiente',
20          'en_curso'   => 'En curso',
21          'finalizado' => 'Finalizado',
22          'cancelado'  => 'Cancelado',
23      ];
...
31          'estados'   => self::ESTADOS,                              ⬅️ ✏️ Proyecto::ESTADOS
44          'estado' => ['required', Rule::in(array_keys(self::ESTADOS))],   ⬅️ ✏️
69          'estado' => ['required', Rule::in(array_keys(self::ESTADOS))],   ⬅️ ✏️
76              . self::ESTADOS[$proyecto->estado] . '.');             ⬅️ ✏️
```

**③ `routes/api.php` → agregar el `use` arriba y la ruta abajo**

```php
 1  <?php
 2
 3  use App\Http\Controllers\Api\ProyectoController;   ⬅️ ➕ import nuevo
 4  use Illuminate\Support\Facades\Route;
 5  use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
 6
 7  Route::get('/proyectos',        [ProyectoController::class, 'index']);     ⬅️ ➕
 8  Route::post('/proyectos',       [ProyectoController::class, 'store']);     ⬅️ ➕
 9  Route::get('/proyectos/{id}',   [ProyectoController::class, 'show']);      ⬅️ ➕
10  Route::put('/proyectos/{id}',   [ProyectoController::class, 'update']);    ⬅️ ➕
11  Route::patch('/proyectos/{id}', [ProyectoController::class, 'update']);    ⬅️ ➕
12  Route::delete('/proyectos/{id}',[ProyectoController::class, 'destroy']);   ⬅️ ➕
13
14  Route::middleware('jwt.custom')->group(function () {   ⬅️ esto ya estaba, no lo borres
15      Route::get('/me', function () {
16          return response()->json(JWTAuth::user());
17      });
18  });
```

> Las 6 líneas equivalen a `Route::apiResource('proyectos', ProyectoController::class);`, pero
> escritas una por una y con el parámetro `{id}` en vez de `{proyecto}` — ver
> [4.1](#41-routesapiphp--lo-que-ya-está).

**④ `bootstrap/app.php` → dentro de `withExceptions`, línea 24 (opcional)**

```php
20      ->withExceptions(function (Exceptions $exceptions): void {
21          $exceptions->shouldRenderJsonWhen(          ⬅️ ⚠️ YA ESTABA, NO LA BORRES
22              fn (Request $request) => $request->is('api/*'),
23          );
24  ← ⬅️ ACÁ va el bloque render() del 404 limpio (Paso 5.1)
25
26      })->create();
```

### 6.7. Cómo verificar que quedó en el lugar correcto

```bash
cd /home/drayer/Proyectos/techsolutiongroups

# ① El archivo existe y está en la carpeta Api/
ls -l app/Http/Controllers/Api/ProyectoController.php

# ② El namespace es el que corresponde a esa ruta
head -3 app/Http/Controllers/Api/ProyectoController.php
# → namespace App\Http\Controllers\Api;

# ③ Laravel encuentra la clase (si esto no falla, el autoload está bien)
php artisan tinker --execute="echo class_exists('App\\Http\\Controllers\\Api\\ProyectoController') ? 'OK' : 'NO LA ENCUENTRA';"

# ④ Las rutas apuntan al controlador de Api\, no al de la web
php artisan route:list --path=api
# La columna de la derecha tiene que decir  Api\ProyectoController@...
```

Si el paso ③ dice `NO LA ENCUENTRA`:

```bash
composer dump-autoload
php artisan optimize:clear
```

---

## 7. Los mensajes en dos idiomas — es / en

**Lectura obligatoria para Pipe y Luisa antes de escribir su método.** Es la parte que más fácil
se rompe sin darse cuenta.

### Qué hace

La aplicación responde en **español o inglés** según lo que pida el navegador. Aplica a los
mensajes de validación de la API *y* a los del formulario web.

```bash
# mismo endpoint, mismo cuerpo inválido, distinto idioma
curl -X POST http://127.0.0.1:8000/api/proyectos -d '{}' \
  -H "Accept: application/json" -H "Content-Type: application/json"
# → "El campo nombre es obligatorio."

curl -X POST "http://127.0.0.1:8000/api/proyectos?lang=en" -d '{}' \
  -H "Accept: application/json" -H "Content-Type: application/json"
# → "The nombre field is required."
```

### 7.1. Los archivos

```
lang/
├── es/
│   ├── validation.php   ← 137 mensajes del validador + custom + attributes
│   ├── auth.php
│   ├── passwords.php
│   └── pagination.php
├── en/                   ← lo mismo, publicado con  php artisan lang:publish
│   └── …
└── en.json              ← las frases de NUESTRO código (los 'mensaje' del envoltorio)
```

**La diferencia entre los `.php` y el `.json`** es la que más confunde:

| | `lang/es/validation.php` | `lang/en.json` |
|---|---|---|
| Para qué | los mensajes que genera **el validador** de Laravel | las frases que escribimos **nosotros** en el controlador |
| Cómo se usan | automático, al fallar una regla | con la función `__('...')` |
| Clave | el nombre de la regla (`required`, `min.string`) | **la frase en español** |
| Hay archivo `es`? | sí, `lang/es/` | **no hace falta**: la clave ya es el español |

### 7.2. Los tres bloques de `lang/es/validation.php`

**a) Los mensajes genéricos** — uno por regla de Laravel:

```php
'required' => 'El campo :attribute es obligatorio.',
'min' => [
    'string' => 'El campo :attribute debe tener al menos :min caracteres.',
    'numeric' => 'El campo :attribute debe ser al menos :min.',
],
```

Los `:placeholders` **no se traducen**: `:attribute` es el campo, `:min` lo completa el
validador.

**b) `custom`** — un mensaje específico para un campo y una regla. **Gana sobre el genérico**:

```php
'custom' => [
    'nombre' => [
        'min' => 'El nombre del proyecto debe tener al menos :min caracteres.',
    ],
    'fecha_inicio' => [
        'after_or_equal' => 'La fecha de inicio no puede ser anterior al año 2010.',
    ],
    'monto' => [
        'min' => 'El monto no puede ser negativo.',
    ],
],
```

Sirve para explicar **el porqué** en vez de repetir la regla en palabras. Comparalo:

| Genérico | Con `custom` |
|---|---|
| El campo fecha de inicio debe ser una fecha igual o posterior a 2010-01-01. | La fecha de inicio no puede ser anterior al año 2010. |
| El campo monto debe ser al menos 0. | El monto no puede ser negativo. |

**c) `attributes`** — el nombre legible de cada campo, reemplaza a `:attribute`:

```php
'attributes' => [
    'fecha_inicio' => 'fecha de inicio',   // sin esto sale "fecha inicio"
    'created_by' => 'usuario creador',     // sin esto sale "created by"
],
```

### 7.3. Cómo elige el idioma

Lo decide `app/Http/Middleware/SetLocale.php`, registrado en `bootstrap/app.php` para los grupos
`web` y `api`. Gana el primero que dé un idioma soportado:

| # | Fuente | Ejemplo |
|---|---|---|
| 1 | `?lang=` en la URL | `/api/proyectos?lang=en` |
| 2 | `session('locale')` | lo que el usuario eligió antes (solo web) |
| 3 | Cabecera `Accept-Language` | `es-CL,es;q=0.9,en;q=0.8` |
| 4 | `config('app.locale')` | `es` |

Los idiomas válidos están en `config/app.php` → `'supported_locales' => ['es', 'en']`.

> **¿Por qué no por IP?** Porque `Accept-Language` es el idioma que la persona **configuró**,
> y la IP es **dónde está parada la conexión**. Un compañero de viaje, una VPN o un hosting en
> otro país darían el idioma equivocado. Además la IP sola no dice el país: haría falta una base
> GeoIP o un servicio externo — una dependencia más, latencia por petición y datos personales
> dando vueltas. El razonamiento largo está en el docblock del middleware.

### 7.4. ⚠️ La regla que NO hay que romper

`Validator::make()` acepta un **tercer argumento** con mensajes. **No se lo pasen.**

```php
// ❌ MAL — este array pisa lang/ y la API responde SIEMPRE en español
$validador = Validator::make($request->all(), $reglas, [
    'required' => 'El campo :attribute es obligatorio.',
]);

// ✅ BIEN — dos argumentos, los textos salen de lang/
$validador = Validator::make($request->all(), $reglas);
```

Una versión anterior de esta guía tenía un método privado `mensajes()` que devolvía justamente
ese array. **Se eliminó** al agregar `lang/`. Si lo ven en algún apunte viejo, ignórenlo.

### 7.5. Cómo agregar una frase nueva

Si tu método necesita un `mensaje` que todavía no existe:

**1.** En el controlador, envolvelo en `__()`:

```php
'mensaje' => __('Proyecto actualizado correctamente.'),
```

**2.** Agregá la traducción en `lang/en.json`:

```json
{
    "Proyecto actualizado correctamente.": "Project updated successfully."
}
```

No hay que tocar ningún archivo en español: **la clave ya es el texto en español**. Si te
olvidás del paso 2, `__()` devuelve la clave tal cual — o sea, sale en español — así que no
rompe nada, pero queda la respuesta mezclada.

**Las frases que van a necesitar Pipe y Luisa ya están cargadas** en `lang/en.json`:

| Clave (español) | Quién la usa |
|---|---|
| `Proyecto encontrado.` | Pipe · `show()` |
| `Proyecto actualizado correctamente.` | Pipe · `update()` |
| `No se pudo actualizar el proyecto: hay campos inválidos.` | Pipe · `update()` |
| `Proyecto ":nombre" eliminado correctamente.` | Luisa · `destroy()` |
| `No existe un proyecto con el id :id.` | los tres · el 404 |
| `La ruta solicitada no existe en esta API.` | Luisa · Paso 5 |

> Las que tienen `:nombre` o `:id` son **frases con parámetro**. Se usan así:
> ```php
> __('No existe un proyecto con el id :id.', ['id' => $id])
> ```
> Laravel reemplaza `:id` por el valor, igual que hace con `:attribute` en las validaciones.

### 7.6. Probar los dos idiomas

```bash
# español (por defecto)
curl -s -X POST http://127.0.0.1:8000/api/proyectos -d '{}' \
  -H "Accept: application/json" -H "Content-Type: application/json" | jq .errores

# inglés, por parámetro (lo más rápido para una captura)
curl -s -X POST "http://127.0.0.1:8000/api/proyectos?lang=en" -d '{}' \
  -H "Accept: application/json" -H "Content-Type: application/json" | jq .errores

# inglés, por cabecera (lo que hace un navegador de verdad)
curl -s -X POST http://127.0.0.1:8000/api/proyectos -d '{}' \
  -H "Accept: application/json" -H "Content-Type: application/json" \
  -H "Accept-Language: en-US,en;q=0.9" | jq .errores
```

---

## Paso 1 — Preparar la rama

```bash
cd /home/drayer/Proyectos/techsolutiongroups

# El árbol de trabajo ya está limpio: JwtMiddleware.php se revirtió al estado
# commiteado (ver 4.3.a). Confirmalo antes de seguir: no debería imprimir nada.
git status --short

git switch dev          # o la rama base que use el equipo
git pull
git switch -c feature/api-crud-proyectos
```

Verificá que el entorno responde:

```bash
php artisan --version            # → Laravel Framework 13.25.0
php artisan migrate:status       # las 4 migraciones en "Ran"
php artisan route:list --path=api
```

---

## Paso 2 — Mover la lista de estados al modelo

**Por qué.** La lista de estados válidos hoy está como constante **`private`** dentro de
`ProyectoController` (el web):

```php
// app/Http/Controllers/ProyectoController.php — ESTADO ACTUAL, línea ~16
private const ESTADOS = [
    'pendiente'  => 'Pendiente',
    'en_curso'   => 'En curso',
    'finalizado' => 'Finalizado',
    'cancelado'  => 'Cancelado',
];
```

Al ser `private`, **el controlador de API no la puede leer**. Si la copiás y pegás allá, tenés
dos listas que se van a desincronizar. La subimos al modelo, que es lo que ambos comparten.

### 2.1. `app/Models/Proyecto.php` — agregar la constante

Pegá esto **dentro de la clase**, justo arriba de `protected $table`:

```php
    /**
     * Estados posibles de un proyecto.
     *
     * ⬆️ MOVIDA ACÁ desde ProyectoController (donde era private const).
     * Ahora es la ÚNICA fuente de verdad y la leen los dos controladores:
     *   · ProyectoController (web)      → los <select> de la vista
     *   · Api\ProyectoController (API)  → Rule::in() de la validación
     *
     * Formato: 'clave_que_se_guarda' => 'Texto para mostrar'
     */
    public const ESTADOS = [
        'pendiente'  => 'Pendiente',
        'en_curso'   => 'En curso',
        'finalizado' => 'Finalizado',
        'cancelado'  => 'Cancelado',
    ];
```

**El resto del modelo queda exactamente igual.** No toques `$fillable`, `$casts` ni `creador()`.

> ⚠️ **Ojo con `$fillable`.** Hoy es
> `['nombre', 'fecha_inicio', 'estado', 'responsable', 'monto']` — `created_by` está fuera **a
> propósito**, para que nadie lo falsee por asignación masiva desde el formulario web.
> **No lo agregues.** En el [Paso 3](#paso-3--apiproyectocontroller-el-archivo-central)
> lo asignamos explícitamente, que es más seguro y no cambia el comportamiento de la web.

### 2.2. `app/Http/Controllers/ProyectoController.php` (web) — 5 reemplazos

**Borrá** la constante privada (las 6 líneas de arriba) y cambiá las 4 apariciones de
`self::ESTADOS` por `Proyecto::ESTADOS`:

```php
// index()
'estados' => Proyecto::ESTADOS,                                      // antes: self::ESTADOS

// store()
'estado' => ['required', Rule::in(array_keys(Proyecto::ESTADOS))],   // antes: self::

// update()
'estado' => ['required', Rule::in(array_keys(Proyecto::ESTADOS))],   // antes: self::

// update(), en el mensaje de éxito
. Proyecto::ESTADOS[$proyecto->estado] . '.');                       // antes: self::
```

`use App\Models\Proyecto;` **ya está importado** en ese archivo, así que no hay que agregar nada.

### 2.3. Verificar que no rompiste la web

```bash
php artisan optimize:clear
php artisan serve
# Entrá a /ingreso, logueate con test@example.com / password,
# andá a /registro-proyecto y confirmá que el <select> muestra las 4 opciones.
```

> **Alternativa sin tocar nada** (si preferís cero cambios en archivos existentes): escribí la
> lista a mano dentro del controlador de API con
> `Rule::in(['pendiente', 'en_curso', 'finalizado', 'cancelado'])`. Funciona igual y da los
> mismos puntos, pero quedan dos listas duplicadas.

### 2.4. Validaciones nuevas en el alta web ✅ (ya hecho)

Aprovechando que se tocaba el archivo, se endurecieron dos reglas del `store()` **web**, para
que el formulario y la API pidan exactamente lo mismo:

```php
// app/Http/Controllers/ProyectoController.php — store()
$datos = $request->validate([
    'nombre'       => ['required', 'string', 'min:5', 'max:100'],              // ← + min:5
    'fecha_inicio' => ['required', 'date', 'after_or_equal:2010-01-01'],       // ← + piso 2010
    'estado'       => ['required', Rule::in(array_keys(Proyecto::ESTADOS))],
    'monto'        => ['required', 'integer', 'min:0', 'max:4294967295'],
]);
```

| Regla | Qué hace | Ojo con |
|---|---|---|
| `min:5` | mínimo 5 **caracteres**, no letras | `"AB 12"` pasa. Para exigir solo letras haría falta un `regex`. |
| `after_or_equal:2010-01-01` | acepta el 1/1/2010 **inclusive** | Si lo querés excluido, es `after:2009-12-31`. |

**`update()` no cambió**: solo valida `estado`, porque es el PATCH del `<select>`.

> Estas dos reglas están repetidas en el `store()` de la API a propósito. Son dos validaciones
> independientes porque son dos puertas de entrada distintas; lo que **no** se duplica es la
> lista de estados, que sale del modelo.

---

## Paso 3 — `Api/ProyectoController` (el archivo central)

**Este archivo es el 100% de la nota.** Los 4 indicadores de la rúbrica se evalúan mirando
estos 5 métodos.

> 📍 **El archivo ya existe** con el esqueleto, `index()` y `store()` terminados. Pipe y Luisa
> **no lo crean de cero**: reemplazan el cuerpo de su método. Ver
> [Estado actual](#-estado-actual-del-proyecto).

### 3.0. Estilo de las respuestas — leer antes de escribir código

Todos los métodos devuelven **el mismo envoltorio JSON**, con estilo clásico y explícito.

```json
{
  "ok": true,
  "codigo": 200,
  "endpoint": "GET /api/proyectos/7",
  "mensaje": "Proyecto encontrado.",
  "data": { }
}
```

| Clave | Qué lleva |
|---|---|
| `ok` | `true` si salió bien, `false` si fue error. Un booleano, para que el cliente no tenga que interpretar el código. |
| `codigo` | El código HTTP **repetido dentro del cuerpo** (200, 201, 404, 422). Redundante a propósito: así se ve en la captura de Postman sin mirar la barra de estado. |
| `endpoint` | El verbo + la ruta que se acaba de ejecutar. Deja claro qué método respondió. |
| `mensaje` | Frase explicando qué pasó. **Va envuelta en `__()`** para que se traduzca — ver [sección 7](#7-los-mensajes-en-dos-idiomas--es--en). |
| `data` | El proyecto, el arreglo de proyectos, o `null` en los errores. |
| `errores` | **Solo en los 422.** El detalle campo por campo que arma el `Validator`. |
| `total` | **Solo en `index()`.** La cantidad de filas devueltas. |

**Cuatro reglas de estilo que van con esto:**

1. **Códigos numéricos literales** (`200`, `201`, `404`, `422`), no las constantes
   `Response::HTTP_OK`. Se lee igual y no hay que importar nada.
2. **404 escrito a mano** con `Proyecto::find($id)` + un `if`, no route model binding. El
   manejo del error **se ve** en el controlador, que es lo que se defiende en la evaluación.
3. **`Validator::make()`** en vez de `$request->validate()`. El `validate()` lanza una excepción
   y deja que Laravel arme el 422 por su cuenta; con `Validator::make()` el
   `if ($validador->fails())` y el cuerpo del error los escribimos nosotros.
4. **`Validator::make()` con DOS argumentos**, nunca tres. El tercero pisaría `lang/`. Ver
   [7.4](#74--la-regla-que-no-hay-que-romper).

> ⚠️ **Dos desvíos conscientes respecto de la letra del enunciado.** Los anotamos acá para que
> nadie se los coma de sorpresa, y ambos se revierten cambiando **una sola línea**:
>
> | Dónde | El PDF pide | Qué hacemos | Cómo volver atrás |
> |---|---|---|---|
> | `index()` con la tabla vacía | un **arreglo vacío** `[]` | un objeto con `"data": []` adentro | `return response()->json($proyectos, 200);` |
> | `destroy()` | **204** con cuerpo **vacío** | **200** con `mensaje` | `return response()->noContent();` |
>
> El resto (201 en `store`, 200 en `show`/`update`, 404 en los tres por id, 422 en las
> validaciones) coincide exactamente con lo que pide el enunciado.

### 3.1. El archivo y sus imports

Se generó con:

```bash
php artisan make:controller Api/ProyectoController --api --model=Proyecto
```

`--api` genera exactamente **5** métodos (`index`, `store`, `show`, `update`, `destroy`) y omite
`create` y `edit`, que sirven para formularios HTML.

> ⚠️ **`--model=Proyecto` deja las firmas con route model binding** (`show(Proyecto $proyecto)`).
> Como vamos con el 404 explícito, **ya fueron cambiadas a `show($id)`**. Si alguien regenera el
> archivo, tiene que volver a cambiarlas.

Los imports que quedaron arriba — **no los toquen**, ya están todos los que hacen falta para los
5 métodos:

```php
use App\Http\Controllers\Controller;
use App\Models\Proyecto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
```

Si dos personas editan esa lista a la vez, Git da conflicto. Por eso están completos desde el
principio.

### 3.2. Contenido completo

#### ✅ `index()` — hecho (Drayer)

```php
/**
 * REQUERIMIENTO 2 — Búsqueda de todos los proyectos.
 *
 *   GET /api/proyectos   → 200
 */
public function index(): JsonResponse
{
    // get() devuelve una Eloquent\Collection. Si la tabla está vacía, la
    // Collection es vacía y "data" sale como [] (corchetes), no como {}.
    $proyectos = Proyecto::orderBy('id')->get();

    return response()->json([
        'ok' => true,
        'codigo' => 200,
        'endpoint' => 'GET /api/proyectos',
        'mensaje' => __('Listado de proyectos obtenido correctamente.'),
        'total' => $proyectos->count(),
        'data' => $proyectos,
    ], 200);
}
```

⚠️ **No usar `->paginate()`**: envolvería el listado en `data`/`links`/`meta` y perderíamos el
control del formato.

#### ✅ `store()` — hecho (Drayer)

```php
/**
 * REQUERIMIENTO 1 — Agregar un proyecto.
 *
 *   POST /api/proyectos   → 201 · 422
 */
public function store(Request $request): JsonResponse
{
    // Validator::make() NO lanza excepción: devuelve un objeto que se consulta
    // con fails(). Así el 422 lo devolvemos nosotros, con el mismo envoltorio
    // que el resto. DOS argumentos: los textos salen de lang/ (ver sección 7).
    $validador = Validator::make($request->all(), [
        'nombre' => ['required', 'string', 'min:5', 'max:100'],
        'fecha_inicio' => ['required', 'date', 'after_or_equal:2010-01-01'],
        'estado' => ['required', Rule::in(array_keys(Proyecto::ESTADOS))],
        'responsable' => ['required', 'string', 'max:100'],
        'monto' => ['required', 'integer', 'min:0', 'max:4294967295'],
        'created_by' => ['required', 'integer', 'exists:usuarios,id'],
    ]);

    if ($validador->fails()) {
        return response()->json([
            'ok' => false,
            'codigo' => 422,
            'endpoint' => 'POST /api/proyectos',
            'mensaje' => __('No se pudo crear el proyecto: hay campos inválidos.'),
            'errores' => $validador->errors(),
            'data' => null,
        ], 422);
    }

    // validated() devuelve SOLO los campos que pasaron por las reglas. Nunca
    // uses $request->all() para guardar: entraría cualquier campo extra.
    $datos = $validador->validated();

    // fill() + save() en vez de Proyecto::create() porque created_by NO está en
    // $fillable (queda fuera a propósito, para que el formulario web no lo pueda
    // falsear por asignación masiva). Asignarlo como propiedad lo esquiva sin
    // debilitarlo.
    $proyecto = new Proyecto();
    $proyecto->fill($datos);                       // los 5 campos fillable
    $proyecto->created_by = $datos['created_by'];  // el 6º, explícito
    $proyecto->save();

    return response()->json([
        'ok' => true,
        'codigo' => 201,
        'endpoint' => 'POST /api/proyectos',
        'mensaje' => __('Proyecto creado correctamente.'),
        'data' => $proyecto,
    ], 201);
}
```

**Las 6 reglas, una por una:**

| Campo | Reglas | Por qué |
|---|---|---|
| `nombre` | `required, string, min:5, max:100` | `max:100` es el `varchar(100)` de la migración. El `min:5` es la misma regla que el formulario web, para que no haya dos criterios. |
| `fecha_inicio` | `required, date, after_or_equal:2010-01-01` | El piso de 2010 descarta fechas cargadas por error (1970, 0001). |
| `estado` | `required, Rule::in(...)` | Lee `Proyecto::ESTADOS`, así la web y la API nunca se desincronizan. |
| `responsable` | `required, string, max:100` | `varchar(100)`. |
| `monto` | `required, integer, min:0, max:4294967295` | Es `unsignedInteger`: sin el `max`, un número mayor lo trunca la base **en silencio**. |
| `created_by` | `required, integer, exists:usuarios,id` | Sin `exists`, un id inventado violaría la FK y daría **500** en vez de 422. |

#### ⏳ `show()` — le toca a **Pipe**

**Lo que hay hoy** (provisorio, para que el archivo compile):

```php
public function show($id): JsonResponse
{
    return response()->json([
        'ok' => false,
        'codigo' => 501,
        'endpoint' => 'GET /api/proyectos/'.$id,
        'mensaje' => 'Endpoint todavía no implementado.',
        'data' => null,
    ], 501);
}
```

**Reemplazalo por:**

```php
/**
 * REQUERIMIENTO 3 — Búsqueda de un proyecto por su ID.
 *
 *   GET /api/proyectos/{id}   → 200 · 404
 *
 * ✔ "Si el Id no existe debe retornar 404"
 *    → find() devuelve null cuando no hay fila con ese id. findOrFail()
 *      lanzaría una excepción y el 404 lo armaría Laravel con SU formato;
 *      acá el if está escrito a mano y el 404 sale con el nuestro.
 * ✔ "La respuesta debe incluir todos los campos" → modelo completo.
 * ✔ "El código de respuesta debe ser 200".
 */
public function show($id): JsonResponse
{
    $proyecto = Proyecto::find($id);

    if ($proyecto === null) {
        return response()->json([
            'ok' => false,
            'codigo' => 404,
            'endpoint' => 'GET /api/proyectos/'.$id,
            'mensaje' => __('No existe un proyecto con el id :id.', ['id' => $id]),
            'data' => null,
        ], 404);
    }

    return response()->json([
        'ok' => true,
        'codigo' => 200,
        'endpoint' => 'GET /api/proyectos/'.$id,
        'mensaje' => __('Proyecto encontrado.'),
        'data' => $proyecto,
    ], 200);
}
```

#### ⏳ `update()` — le toca a **Pipe**

```php
/**
 * REQUERIMIENTO 4 — Actualizar un proyecto por su ID.
 *
 *   PUT   /api/proyectos/{id}   → 200 · 404 · 422
 *   PATCH /api/proyectos/{id}   → 200 · 404 · 422
 *
 * El enunciado acepta los dos verbos, y la ruta los manda al mismo método.
 *
 * ⚠️ El PDF se contradice: el encabezado del requerimiento dice 201 y la
 *    viñeta dice 200. Usamos 200 porque es lo correcto en HTTP (no se creó
 *    nada nuevo). Si el profesor aclara que quiere 201, hay que cambiar los
 *    DOS 200 del return final ('codigo' y el argumento).
 */
public function update(Request $request, $id): JsonResponse
{
    // El método HTTP real (PUT o PATCH), para que la respuesta diga cuál se usó.
    $verbo = $request->method();

    $proyecto = Proyecto::find($id);

    if ($proyecto === null) {
        return response()->json([
            'ok' => false,
            'codigo' => 404,
            'endpoint' => $verbo.' /api/proyectos/'.$id,
            'mensaje' => __('No existe un proyecto con el id :id.', ['id' => $id]),
            'data' => null,
        ], 404);
    }

    // 'sometimes' + 'required' es la combinación clave:
    //   · sometimes → si el campo NO viene, no se valida  → permite PATCH parcial
    //   · required  → si el campo SÍ viene, no puede estar vacío
    // Así el mismo método sirve para PUT (mandás todo) y PATCH (solo lo que cambia).
    $validador = Validator::make($request->all(), [
        'nombre' => ['sometimes', 'required', 'string', 'min:5', 'max:100'],
        'fecha_inicio' => ['sometimes', 'required', 'date', 'after_or_equal:2010-01-01'],
        'estado' => ['sometimes', 'required', Rule::in(array_keys(Proyecto::ESTADOS))],
        'responsable' => ['sometimes', 'required', 'string', 'max:100'],
        'monto' => ['sometimes', 'required', 'integer', 'min:0', 'max:4294967295'],
        'created_by' => ['sometimes', 'required', 'integer', 'exists:usuarios,id'],
    ]);

    if ($validador->fails()) {
        return response()->json([
            'ok' => false,
            'codigo' => 422,
            'endpoint' => $verbo.' /api/proyectos/'.$id,
            'mensaje' => __('No se pudo actualizar el proyecto: hay campos inválidos.'),
            'errores' => $validador->errors(),
            'data' => null,
        ], 422);
    }

    $datos = $validador->validated();

    $proyecto->fill($datos);

    // created_by aparte, por el mismo motivo que en store(): no está en $fillable.
    // array_key_exists y no isset() porque isset() da false si el valor fuera null.
    if (array_key_exists('created_by', $datos)) {
        $proyecto->created_by = $datos['created_by'];
    }

    $proyecto->save();

    return response()->json([
        'ok' => true,
        'codigo' => 200,
        'endpoint' => $verbo.' /api/proyectos/'.$id,
        'mensaje' => __('Proyecto actualizado correctamente.'),
        // refresh() relee la fila desde la base: así el JSON trae el updated_at
        // real y no el que el objeto tenía en memoria.
        'data' => $proyecto->refresh(),
    ], 200);
}
```

#### ⏳ `destroy()` — le toca a **Luisa**

```php
/**
 * REQUERIMIENTO 5 — Eliminar un proyecto por su ID.
 *
 *   DELETE /api/proyectos/{id}   → 200 · 404
 *
 * ⚠️ El enunciado pedía 204 con cuerpo vacío. El equipo decidió devolver 200
 *    con confirmación, para que la respuesta se pueda leer en Postman igual
 *    que las otras cuatro. Un 204 no lleva cuerpo por definición, así que
 *    "204 + mensaje" no existe: hay que elegir uno.
 *    Para volver al 204 de la rúbrica: return response()->noContent();
 *    (y cambiar el tipo de retorno a \Illuminate\Http\Response).
 */
public function destroy($id): JsonResponse
{
    $proyecto = Proyecto::find($id);

    if ($proyecto === null) {
        return response()->json([
            'ok' => false,
            'codigo' => 404,
            'endpoint' => 'DELETE /api/proyectos/'.$id,
            'mensaje' => __('No existe un proyecto con el id :id.', ['id' => $id]),
            'data' => null,
        ], 404);
    }

    // Guardamos el nombre ANTES de borrar, para poder nombrarlo en el mensaje.
    $nombre = $proyecto->nombre;

    $proyecto->delete();

    return response()->json([
        'ok' => true,
        'codigo' => 200,
        'endpoint' => 'DELETE /api/proyectos/'.$id,
        'mensaje' => __('Proyecto ":nombre" eliminado correctamente.', ['nombre' => $nombre]),
        'data' => null,
    ], 200);
}
```

#### 📌 Lo que los tres tienen en común

El bloque del **404 es idéntico** en `show()`, `update()` y `destroy()` salvo por el verbo del
`endpoint`. **Cópienlo, no lo reescriban de memoria** — si los tres 404 no devuelven la misma
estructura, se nota en la corrección.

```php
if ($proyecto === null) {
    return response()->json([
        'ok' => false,
        'codigo' => 404,
        'endpoint' => '<VERBO> /api/proyectos/'.$id,
        'mensaje' => __('No existe un proyecto con el id :id.', ['id' => $id]),
        'data' => null,
    ], 404);
}
```

### 3.3. Por qué 404 a mano y no route model binding

Laravel tiene un atajo llamado **route model binding**: si tipás el parámetro como
`show(Proyecto $proyecto)`, busca la fila por id antes de entrar al método y lanza un 404 solo
si no la encuentra. Es la forma idiomática y ahorra 6 líneas por método.

**No lo usamos**, por tres razones:

1. **El manejo del error no se ve.** En una evaluación, un método de una línea sin ningún `if`
   no demuestra que sepas manejar el caso "no existe": lo hace el framework por vos.
2. **El cuerpo del 404 no es tuyo.** Lo arma Laravel, y con `APP_DEBUG=true` incluye el nombre
   de la clase del modelo y un stack trace.
3. **Consistencia.** Los tres métodos por id hacen exactamente lo mismo y devuelven exactamente
   el mismo JSON.

Lo que **sí** hay que respetar: elegir una y usarla en los tres. Lo que resta puntos es
mezclarlas.

---

## Paso 4 — Registrar las rutas

> 👥 **Le toca a Luisa.** Las 2 rutas de Drayer **ya están**; faltan las 4 restantes.

### 4.0. Van en `routes/api.php`, NUNCA en `routes/web.php`

Esto ya rompió el proyecto una vez, así que va primero. Poner los endpoints en `web.php`
produce **tres** problemas distintos:

**1. Fatal error: los dos controladores se llaman igual.**

```php
// routes/web.php
use App\Http\Controllers\ProyectoController;        // el de la web
use App\Http\Controllers\Api\ProyectoController;    // ⛔
```

```
Cannot use App\Http\Controllers\Api\ProyectoController as ProyectoController
because the name is already in use   —  routes/web.php:8
```

Un `use` importa el **nombre corto**. Los dos controladores se llaman `ProyectoController` y
solo los distingue el namespace, así que PHP no admite los dos en el mismo archivo. Es un error
de arranque: **ninguna ruta del sitio funciona**, ni la web ni la API.

**2. Sin el prefijo `api/`, los errores salen en HTML.**

El JSON lo fuerza esta línea de `bootstrap/app.php`:

```php
$exceptions->shouldRenderJsonWhen(fn ($request) => $request->is('api/*'));
```

Solo aplica a rutas que empiezan con `api/`. Comprobado:

```
/api/proyectos  → HTTP 404  JSON   ← ruta inexistente, pero responde JSON
/proyectos      → HTTP 500  HTML   ← fuera de api/*, sale como página web
```

**3. El grupo `web` agrega protección CSRF.** Postman no manda token CSRF, así que cualquier
`POST` desde ahí devolvería **419 Page Expired**. Las rutas de `api.php` son stateless y no
tienen ese middleware.

> Si algún día hicieran falta los dos controladores en el mismo archivo, se resuelve con un
> alias: `use App\Http\Controllers\Api\ProyectoController as ApiProyectoController;`. Acá no
> hace falta: cada uno va en su archivo de rutas.

### 4.1. `routes/api.php` — lo que ya está

```php
<?php

use App\Http\Controllers\Api\ProyectoController;
use Illuminate\Support\Facades\Route;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

// REQUERIMIENTO 2 — listar todos      → 200
Route::get('/proyectos', [ProyectoController::class, 'index']);

// REQUERIMIENTO 1 — crear             → 201 · 422
Route::post('/proyectos', [ProyectoController::class, 'store']);

Route::middleware('jwt.custom')->group(function () {
    Route::get('/me', function () {
        return response()->json(JWTAuth::user());
    });
});
```

**El prefijo `/api` lo agrega Laravel solo.** `bootstrap/app.php` carga este archivo con
`->withRouting(api: __DIR__.'/../routes/api.php', ...)`, así que `Route::get('/proyectos', ...)`
se sirve en `/api/proyectos`. No hay que escribirlo.

### 4.2. Lo que Luisa agrega

Las 4 líneas que faltan, justo debajo del `POST`:

```php
// REQUERIMIENTO 3 — ver uno por id                      → 200 · 404
Route::get('/proyectos/{id}', [ProyectoController::class, 'show']);

// REQUERIMIENTO 4 — actualizar por id                   → 200 · 404 · 422
// El enunciado acepta los dos verbos, y los dos van al mismo método.
Route::put('/proyectos/{id}', [ProyectoController::class, 'update']);
Route::patch('/proyectos/{id}', [ProyectoController::class, 'update']);

// REQUERIMIENTO 5 — eliminar por id                     → 200 · 404
Route::delete('/proyectos/{id}', [ProyectoController::class, 'destroy']);
```

**`{id}` y no `{proyecto}`.** El nombre del parámetro de la ruta tiene que coincidir con el de
la variable del método (`show($id)`). Si en la ruta ponés `{proyecto}` y en el método `$id`,
llega `null`, `find(null)` no encuentra nada y **todos** los ids darían 404, incluso los que
existen.

> 💡 **La versión corta, por si la comparan.** `Route::apiResource('proyectos',
> ProyectoController::class);` genera estas 6 rutas en una línea, pero con el parámetro llamado
> `{proyecto}` (para el route model binding). Elegimos la explícita para que cada verbo se lea.

### 4.3. Verificar

```bash
php artisan optimize:clear
php artisan route:list --path=api
```

Con las 2 rutas actuales tienen que salir **3 líneas**:

```
GET|HEAD   api/me
GET|HEAD   api/proyectos ............ Api\ProyectoController@index
POST       api/proyectos ............ Api\ProyectoController@store
```

Cuando Luisa agregue las suyas, **7**:

```
GET|HEAD   api/me
GET|HEAD   api/proyectos ............ Api\ProyectoController@index
POST       api/proyectos ............ Api\ProyectoController@store
GET|HEAD   api/proyectos/{id} ....... Api\ProyectoController@show
PUT        api/proyectos/{id} ....... Api\ProyectoController@update
PATCH      api/proyectos/{id} ....... Api\ProyectoController@update
DELETE     api/proyectos/{id} ...... Api\ProyectoController@destroy
```

**Tres cosas para confirmar:**
1. Aparecen **`PUT` y `PATCH`** apuntando los dos a `update`.
2. El parámetro dice **`{id}`**, no `{proyecto}`.
3. **No** aparecen rutas `create` ni `edit`.

> Si `route:list` tira un fatal error en vez de listar, revisá que no haya quedado un
> `use App\Http\Controllers\Api\ProyectoController;` en `routes/web.php` — ver
> [4.0](#40-van-en-routesapiphp-nunca-en-routeswebphp).

---

## Paso 5 — 404 de rutas inexistentes (opcional)

> 👥 **También le toca a Luisa**, va junto con el paso 4.

**Qué cambió respecto de la versión anterior de esta guía.** Antes este paso servía para tapar
el 404 feo que generaba el route model binding. Como ahora el 404 de "id que no existe" lo arma
el controlador a mano (con nuestro `mensaje` y nuestro `endpoint`), **ese problema ya no
existe** y el paso es puramente cosmético.

Lo único que sigue saliendo con formato ajeno es una **ruta que no existe en absoluto**, por
ejemplo un typo:

```bash
curl -s http://127.0.0.1:8000/api/proyecto/1 -H "Accept: application/json"
```

```json
{
  "message": "",
  "exception": "Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException",
  "file": "/home/drayer/.../Illuminate/Routing/AbstractRouteCollection.php",
  "trace": [ ... 60 líneas de stack trace ... ]
}
```

El código ya es 404, así que no cuesta puntos. Pero filtra rutas internas del servidor. Con 10
líneas queda del mismo color que el resto de la API.

### 5.1. `bootstrap/app.php`

Agregá el `use` arriba y el bloque `render()` dentro de `withExceptions`:

```php
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;   // ← import nuevo

// ...

    ->withExceptions(function (Exceptions $exceptions): void {

        // ⚠️ ESTA LÍNEA YA ESTABA — NO LA BORRES.
        // Fuerza respuestas JSON en /api/* aunque el cliente no mande el header
        // "Accept: application/json". Con Validator::make() ya no la necesitamos
        // para los 422 (esos los devolvemos nosotros), pero sigue haciendo falta
        // para cualquier excepción que Laravel maneje por su cuenta.
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );

        // ↓ BLOQUE NUEVO
        // Se dispara cuando NINGUNA ruta coincide con la URL pedida (un typo en
        // el endpoint, por ejemplo). El 404 por "id que no existe" NO pasa por
        // acá: ese lo devuelve el controlador con find() + if.
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'ok'       => false,
                    'codigo'   => 404,
                    'endpoint' => $request->method().' /'.$request->path(),
                    'mensaje'  => 'La ruta solicitada no existe en esta API.',
                    'data'     => null,
                ], 404);
            }
        });

    })->create();
```

```bash
php artisan optimize:clear
```

> **Ojo con el orden de los `render()`.** Los callbacks se evalúan de arriba hacia abajo y gana
> el primero cuyo tipo de excepción coincida. `NotFoundHttpException` es la clase padre a la que
> Laravel convierte varias excepciones de ruteo, así que este bloque va **al final** del
> `withExceptions`, después de cualquier otro `render()` más específico.

---

## Paso 6 — Probar los 4 indicadores de la rúbrica

Levantá el servidor en una terminal:

```bash
php artisan serve      # → http://127.0.0.1:8000
```

> Los comandos de abajo están en sintaxis **fish** (tu shell). Al final hay una tabla de
> equivalencias para el resto del equipo, que trabaja en PowerShell.
> `jq` es opcional (`sudo pacman -S jq`): solo formatea el JSON.
> El flag **`-w "\n→ HTTP %{http_code}\n"` imprime el código de estado**, que es lo que la
> rúbrica evalúa: no lo saques.

> 📋 **Qué mirar en cada respuesta.** Con el envoltorio de la sección
> [3.0](#30-estilo-de-las-respuestas--leer-antes-de-escribir-código), cada prueba se verifica en
> dos lugares que tienen que coincidir: el **código HTTP** que imprime curl al final, y la clave
> **`"codigo"`** dentro del JSON. Si no coinciden, alguien escribió mal uno de los dos números.

### ✅ Indicador 1 — Inserta nuevos registros (26 pts)

```fish
# 1.1 — POST correcto → tiene que devolver 201
curl -s -w "\n→ HTTP %{http_code}\n" -X POST http://127.0.0.1:8000/api/proyectos \
  -H "Accept: application/json" -H "Content-Type: application/json" \
  -d '{
        "nombre": "Cableado sucursal centro",
        "fecha_inicio": "2026-10-01",
        "estado": "pendiente",
        "responsable": "Drayer Yoncley",
        "monto": 1500000,
        "created_by": 1
      }' | jq
```

Esperado: **`HTTP 201`** y este cuerpo:

```json
{
  "ok": true,
  "codigo": 201,
  "endpoint": "POST /api/proyectos",
  "mensaje": "Proyecto creado correctamente.",
  "data": {
    "nombre": "Cableado sucursal centro",
    "fecha_inicio": "2026-10-01T00:00:00.000000Z",
    "estado": "pendiente",
    "responsable": "Drayer Yoncley",
    "monto": 1500000,
    "created_by": 1,
    "updated_at": "2026-09-04T16:20:00.000000Z",
    "created_at": "2026-09-04T16:20:00.000000Z",
    "id": 7
  }
}
```

```fish
# 1.2 — Cuerpo vacío → 422 con los 6 campos en "errores"
curl -s -w "\n→ HTTP %{http_code}\n" -X POST http://127.0.0.1:8000/api/proyectos \
  -H "Accept: application/json" -H "Content-Type: application/json" \
  -d '{}' | jq

# 1.3 — Campos vacíos ("no deben estar vacíos") → 422
curl -s -w "\n→ HTTP %{http_code}\n" -X POST http://127.0.0.1:8000/api/proyectos \
  -H "Accept: application/json" -H "Content-Type: application/json" \
  -d '{"nombre":"","fecha_inicio":"","estado":"","responsable":"","monto":"","created_by":""}' | jq

# 1.4 — Datos inválidos: estado inventado, monto negativo, usuario inexistente → 422
curl -s -w "\n→ HTTP %{http_code}\n" -X POST http://127.0.0.1:8000/api/proyectos \
  -H "Accept: application/json" -H "Content-Type: application/json" \
  -d '{
        "nombre": "Prueba",
        "fecha_inicio": "no-es-fecha",
        "estado": "inventado",
        "responsable": "X",
        "monto": -50,
        "created_by": 9999
      }' | jq
```

**1.2, 1.3 y 1.4 son la evidencia de las validaciones**, que es el salto de *Medio* (18) a
*Alto* (22). Sacales captura para la entrega. El cuerpo del 422 se ve así:

```json
{
  "ok": false,
  "codigo": 422,
  "endpoint": "POST /api/proyectos",
  "mensaje": "No se pudo crear el proyecto: hay campos inválidos.",
  "errores": {
    "nombre":       ["El nombre del proyecto debe tener al menos 5 caracteres."],
    "fecha_inicio": ["La fecha de inicio no puede ser anterior al año 2010."],
    "estado":       ["El estado debe ser uno de los cuatro válidos: pendiente, en curso, finalizado o cancelado."],
    "monto":        ["El monto no puede ser negativo."],
    "created_by":   ["El usuario indicado en created_by no existe."]
  },
  "data": null
}
```

> `responsable` **no** aparece: `"X"` cumple `required`, `string` y `max:100`. Está así a
> propósito, para que se vea que solo fallan los campos que tienen que fallar.

### 📮 Cuerpos para Postman — copiar y pegar

Todos verificados contra el servidor. En Postman: **Body → raw → JSON**.
`created_by` válidos hoy: **1**, **2**, **3**.

**A. Válido → 201**

```json
{
    "nombre": "Cableado sucursal centro",
    "fecha_inicio": "2026-10-01",
    "estado": "pendiente",
    "responsable": "Drayer Yoncley",
    "monto": 1500000,
    "created_by": 3
}
```

**B. Cuerpo vacío → 422 con los 6 campos**

```json
{}
```

**C. Campos en cadena vacía → 422** *(los mismos 6 mensajes que B)*

```json
{
    "nombre": "",
    "fecha_inicio": "",
    "estado": "",
    "responsable": "",
    "monto": "",
    "created_by": ""
}
```

Esta es la que prueba el *"no deben estar vacíos"* del enunciado: demuestra que `required`
rechaza la cadena vacía, no solo el campo ausente. **Va con captura aparte.**

**D. Una regla por vez** — los otros 5 campos correctos, para aislar cada mensaje:

| Rompe | Cuerpo (cambiá solo ese campo sobre el cuerpo A) | Mensaje |
|---|---|---|
| `min:5` | `"nombre": "abc"` | El nombre del proyecto debe tener al menos 5 caracteres. |
| fecha < 2010 | `"fecha_inicio": "2009-12-31"` | La fecha de inicio no puede ser anterior al año 2010. |
| `min:0` | `"monto": -1` | El monto no puede ser negativo. |
| `Rule::in` | `"estado": "En curso"` | El estado debe ser uno de los cuatro válidos: … |
| `exists` | `"created_by": 9999` | El usuario indicado en created_by no existe. |

⚠️ **El del `estado` es el error más fácil de cometer:** `"En curso"` es lo que se **muestra**,
`"en_curso"` es lo que se **guarda**. La clave lleva guion bajo y va en minúsculas.

⚠️ **El de `created_by` es el que evita el 500:** sin la regla `exists`, el INSERT violaría la
clave foránea y reventaría el servidor en vez de devolver 422.

**E. Todo roto de una → 422 con 5 errores**

```json
{
    "nombre": "abc",
    "fecha_inicio": "2005-01-01",
    "estado": "inventado",
    "responsable": "X",
    "monto": -50,
    "created_by": 9999
}
```

**F. En inglés** — mismo cuerpo, agregale `?lang=en` a la URL:

`POST http://127.0.0.1:8000/api/proyectos?lang=en`

```
nombre:       The nombre field is required.
fecha_inicio: The fecha inicio field is required.
estado:       The estado field is required.
...
```

También funciona con el header `Accept-Language: en-US,en;q=0.9`, que es lo que manda un
navegador de verdad. Para una captura, el `?lang=` es más rápido.

### ✅ Indicador 2 — Recupera datos existentes (26 pts)

```fish
# 2.1 — Listar todos → 200
curl -s -w "\n→ HTTP %{http_code}\n" http://127.0.0.1:8000/api/proyectos \
  -H "Accept: application/json" | jq

# 2.2 — Con la tabla vacía: "data" tiene que ser [] y "total" 0
#        (borrá todos los proyectos primero, o probá antes de crear ninguno)
php artisan tinker --execute="App\Models\Proyecto::query()->delete();"
curl -s -w "\n→ HTTP %{http_code}\n" http://127.0.0.1:8000/api/proyectos \
  -H "Accept: application/json" | jq
# → {"ok":true,"codigo":200,"endpoint":"GET /api/proyectos","mensaje":"...","total":0,"data":[]}
# → HTTP 200

# 2.3 — Buscar uno que existe → 200 con todos los campos
curl -s -w "\n→ HTTP %{http_code}\n" http://127.0.0.1:8000/api/proyectos/1 \
  -H "Accept: application/json" | jq

# 2.4 — Buscar uno que NO existe → 404
curl -s -w "\n→ HTTP %{http_code}\n" http://127.0.0.1:8000/api/proyectos/99999 \
  -H "Accept: application/json" | jq
```

La 2.4 tiene que devolver **exactamente** esto, con el mensaje nuestro y sin ningún stack trace:

```json
{
  "ok": false,
  "codigo": 404,
  "endpoint": "GET /api/proyectos/99999",
  "mensaje": "No existe un proyecto con el id 99999.",
  "data": null
}
```

> ⚠️ **La 2.2 era la trampa del enunciado.** El PDF pedía literalmente un arreglo `[]` como
> respuesta completa. Con el envoltorio, el `[]` está **adentro de `data`**. Es el desvío
> consciente que documenta la sección [3.0](#30-estilo-de-las-respuestas--leer-antes-de-escribir-código);
> si el profesor lo objeta, se revierte cambiando una línea de `index()`.
> Lo que **sí** hay que confirmar es que `data` sale como `[]` (corchetes) y **no** como `{}`:
> si sale `{}` es porque devolviste un objeto en vez de una colección.

### ✅ Indicador 3 — Actualiza registros existentes (24 pts)

```fish
# 3.1 — PATCH parcial (solo el estado) → 200 con todos los campos actualizados
curl -s -w "\n→ HTTP %{http_code}\n" -X PATCH http://127.0.0.1:8000/api/proyectos/1 \
  -H "Accept: application/json" -H "Content-Type: application/json" \
  -d '{"estado": "en_curso"}' | jq
# En el cuerpo, "endpoint" tiene que decir  PATCH /api/proyectos/1

# 3.2 — PUT completo → 200
curl -s -w "\n→ HTTP %{http_code}\n" -X PUT http://127.0.0.1:8000/api/proyectos/1 \
  -H "Accept: application/json" -H "Content-Type: application/json" \
  -d '{
        "nombre": "Cableado sucursal centro (fase 2)",
        "fecha_inicio": "2026-11-15",
        "estado": "finalizado",
        "responsable": "Drayer Yoncley",
        "monto": 2100000,
        "created_by": 1
      }' | jq
# Y acá "endpoint" tiene que decir  PUT /api/proyectos/1
# Es la prueba de que $request->method() distingue los dos verbos.

# 3.3 — Actualizar un id inexistente → 404
curl -s -w "\n→ HTTP %{http_code}\n" -X PATCH http://127.0.0.1:8000/api/proyectos/99999 \
  -H "Accept: application/json" -H "Content-Type: application/json" \
  -d '{"estado": "cancelado"}' | jq

# 3.4 — Actualizar con un dato inválido → 422
curl -s -w "\n→ HTTP %{http_code}\n" -X PATCH http://127.0.0.1:8000/api/proyectos/1 \
  -H "Accept: application/json" -H "Content-Type: application/json" \
  -d '{"estado": "estado-que-no-existe"}' | jq
```

### ✅ Indicador 4 — Elimina registros (24 pts)

```fish
# 4.1 — Eliminar uno que existe → 200 con el mensaje de confirmación
curl -s -w "\n→ HTTP %{http_code}\n" -X DELETE http://127.0.0.1:8000/api/proyectos/1 \
  -H "Accept: application/json" | jq
# → {"ok":true,"codigo":200,"endpoint":"DELETE /api/proyectos/1",
#    "mensaje":"Proyecto \"Cableado sucursal centro\" eliminado correctamente.","data":null}
# → HTTP 200

# 4.2 — Confirmar que se borró de verdad → 404
curl -s -w "\n→ HTTP %{http_code}\n" http://127.0.0.1:8000/api/proyectos/1 \
  -H "Accept: application/json" | jq

# 4.3 — Eliminar un id inexistente → 404
curl -s -w "\n→ HTTP %{http_code}\n" -X DELETE http://127.0.0.1:8000/api/proyectos/99999 \
  -H "Accept: application/json" | jq
```

> ⚠️ **Acá el enunciado pedía 204 con cuerpo vacío** y nosotros devolvemos 200 con mensaje. Es
> el segundo desvío consciente de la sección
> [3.0](#30-estilo-de-las-respuestas--leer-antes-de-escribir-código). Si lo revierten, la 4.1
> pasa a probarse con `curl -i` (para ver que después de los headers no hay nada) y el código
> esperado vuelve a ser **204**.

### Script que corre las 13 pruebas de una

Guardalo como `probar-api.fish` en la raíz del proyecto (o pegalo en la terminal):

```fish
#!/usr/bin/env fish
set BASE "http://127.0.0.1:8000/api/proyectos"
set H    -H "Accept: application/json" -H "Content-Type: application/json"

function probar -a etiqueta esperado
    # $argv[3..] son los argumentos que se le pasan a curl
    set codigo (curl -s -o /dev/null -w "%{http_code}" $argv[3..-1])
    if test "$codigo" = "$esperado"
        echo "  ✅ $etiqueta → $codigo"
    else
        echo "  ❌ $etiqueta → esperaba $esperado, recibí $codigo"
    end
end

echo "── Indicador 1: POST ──────────────────────────────"
probar "POST válido"            201 -X POST $BASE $H -d '{"nombre":"Test","fecha_inicio":"2026-10-01","estado":"pendiente","responsable":"QA","monto":1000,"created_by":1}'
probar "POST vacío"             422 -X POST $BASE $H -d '{}'
probar "POST estado inválido"   422 -X POST $BASE $H -d '{"nombre":"T","fecha_inicio":"2026-10-01","estado":"xx","responsable":"QA","monto":1000,"created_by":1}'
probar "POST usuario inexistente" 422 -X POST $BASE $H -d '{"nombre":"T","fecha_inicio":"2026-10-01","estado":"pendiente","responsable":"QA","monto":1000,"created_by":9999}'

echo "── Indicador 2: GET ───────────────────────────────"
probar "GET todos"              200 $BASE $H
probar "GET uno existente"      200 "$BASE/1" $H
probar "GET id inexistente"     404 "$BASE/99999" $H

echo "── Indicador 3: PUT / PATCH ───────────────────────"
probar "PATCH parcial"          200 -X PATCH "$BASE/1" $H -d '{"estado":"en_curso"}'
probar "PUT completo"           200 -X PUT   "$BASE/1" $H -d '{"nombre":"T2","fecha_inicio":"2026-11-01","estado":"finalizado","responsable":"QA","monto":2000,"created_by":1}'
probar "PATCH id inexistente"   404 -X PATCH "$BASE/99999" $H -d '{"estado":"cancelado"}'
probar "PATCH dato inválido"    422 -X PATCH "$BASE/1" $H -d '{"estado":"xx"}'

echo "── Indicador 4: DELETE ────────────────────────────"
probar "DELETE existente"       200 -X DELETE "$BASE/1" $H
probar "DELETE id inexistente"  404 -X DELETE "$BASE/99999" $H
```

```bash
chmod +x probar-api.fish
./probar-api.fish
```

**Si las 13 salen en verde, el CRUD responde con los códigos que documentamos.**

> El script solo compara **códigos HTTP**. La clave `"codigo"` del cuerpo hay que mirarla a ojo
> al menos una vez por endpoint, o agregarle al script un `| jq -r .codigo` y comparar los dos.

### Equivalencias para PowerShell

La guía de instalación ya avisa: en PowerShell hay que usar **`curl.exe`**, porque `curl` a
secas es un alias de `Invoke-WebRequest` y no entiende `-X`, `-H` ni `-i`.

| fish / bash | PowerShell |
|---|---|
| `curl` | `curl.exe` |
| `-d '{"a":"b"}'` | `-d '{\"a\":\"b\"}'` (comillas escapadas) |
| Continuación de línea `\` | Backtick `` ` `` |
| `set VAR (comando)` | `$VAR = comando` |
| `\| jq` | `\| ConvertFrom-Json \| ConvertTo-Json` |

```powershell
curl.exe -s -w "`n-> HTTP %{http_code}`n" -X POST http://127.0.0.1:8000/api/proyectos `
  -H "Accept: application/json" -H "Content-Type: application/json" `
  -d '{\"nombre\":\"Cableado\",\"fecha_inicio\":\"2026-10-01\",\"estado\":\"pendiente\",\"responsable\":\"Drayer\",\"monto\":1500000,\"created_by\":1}'
```

### Postman (recomendado para la evidencia de entrega)

Armá una colección **EV_U3 — API Proyectos** con estas 5 peticiones y guardá las capturas:

```
EV_U3 — API Proyectos
├── Variable de colección: base_url = http://127.0.0.1:8000/api
├── 1. POST   {{base_url}}/proyectos          → 201
├── 2. GET    {{base_url}}/proyectos          → 200
├── 3. GET    {{base_url}}/proyectos/1        → 200   (y /99999 → 404)
├── 4. PATCH  {{base_url}}/proyectos/1        → 200   (y /99999 → 404)
└── 5. DELETE {{base_url}}/proyectos/1        → 200   (y /99999 → 404)
```

En cada petición, pestaña **Headers**: `Accept: application/json` y
`Content-Type: application/json`. En **Body** elegí **raw → JSON**.

Podés agregar tests automáticos en la pestaña **Scripts → Post-response**, y que Postman te
marque en verde el código correcto **y** que el cuerpo lo repita:

```javascript
// En la petición POST
pm.test("Devuelve 201 Created", () => pm.response.to.have.status(201));
pm.test("El cuerpo repite el codigo", () => {
    pm.expect(pm.response.json().codigo).to.eql(201);
});

// En la petición DELETE
pm.test("Devuelve 200 con confirmacion", () => {
    pm.response.to.have.status(200);
    pm.expect(pm.response.json().ok).to.be.true;
    pm.expect(pm.response.json().mensaje).to.include("eliminado");
});

// En cualquier petición por id que no existe
pm.test("404 con mensaje propio", () => {
    pm.response.to.have.status(404);
    pm.expect(pm.response.json().mensaje).to.include("No existe un proyecto");
    pm.expect(pm.response.text()).to.not.include("exception");   // sin stack trace
});
```

Exportá la colección (`Collection → Export → v2.1`) y sumala al ZIP de la entrega.

---

## Checklist de autoevaluación (puntaje esperado)

Marcá cada casilla probándola de verdad, no de memoria.

### Indicador 1 — Inserta (26 pts)
- [ ] Existe `app/Http/Controllers/Api/ProyectoController.php` con el método `store()`
- [ ] `POST /api/proyectos` con datos válidos → **201** *(← +4 pts sobre "Alto")*
- [ ] La clave `"codigo"` del cuerpo también dice **201** (coincide con el código HTTP)
- [ ] `"data"` incluye el `id` generado y los 6 campos
- [ ] Los **6** campos tienen `required` *(← +4 pts sobre "Medio")*
- [ ] `POST` con `{}` → **422** con los 6 campos en `errors`
- [ ] `POST` con campos en `""` → **422**
- [ ] `estado` inválido → **422** · `monto` negativo → **422** · `created_by` inexistente → **422**
- [ ] El registro quedó realmente en la base (`GET /api/proyectos` lo muestra)

### Indicador 2 — Recupera (26 pts)
- [ ] `GET /api/proyectos` → **200**
- [ ] `"data"` trae **todos los campos** de cada proyecto
- [ ] Con la tabla vacía, `"data"` es **`[]`** (corchetes) y `"total"` es `0`
- [ ] `GET /api/proyectos/{id}` existente → **200** con todos los campos
- [ ] `GET /api/proyectos/99999` → **404** *(← el error de ejecución que baja a "Medio")*
- [ ] Ese 404 sale con **nuestro** `mensaje`, sin `exception` ni `trace` en el cuerpo
- [ ] Ningún endpoint devuelve **500**

### Indicador 3 — Actualiza (24 pts)
- [ ] La ruta acepta **`PUT` y `PATCH`** (verificado en `route:list`)
- [ ] `PATCH` con un solo campo → **200**, el resto de los campos sin tocar
- [ ] `PUT` con todos los campos → **200**
- [ ] La respuesta incluye **todos los campos ya actualizados**
- [ ] `"endpoint"` dice `PUT ...` o `PATCH ...` según el verbo que usaste
- [ ] `PATCH /api/proyectos/99999` → **404**
- [ ] `PATCH` con `estado` inválido → **422** con el detalle en `"errores"`
- [ ] ⚠️ Confirmaste con el profesor si quiere **200** o **201** ([§3](#3-la-contradicción-del-enunciado-en-putpatch))

### Indicador 4 — Elimina (24 pts)
- [ ] `DELETE /api/proyectos/{id}` → **200** con el mensaje de confirmación
- [ ] El registro desapareció de la base (`GET` del mismo id → **404**)
- [ ] `DELETE /api/proyectos/99999` → **404**
- [ ] ⚠️ Confirmaste con el profesor que acepta **200 con mensaje** en vez del **204** vacío
      del PDF ([3.0](#30-estilo-de-las-respuestas--leer-antes-de-escribir-código))

### Consistencia entre los tres (nuevo — revisar antes de mergear)
- [ ] Los 3 métodos por id (`show`, `update`, `destroy`) devuelven **el mismo JSON de 404**
- [ ] Los 5 métodos usan las mismas 5 claves: `ok`, `codigo`, `endpoint`, `mensaje`, `data`
- [ ] Ningún método quedó con `Response::HTTP_*`, `findOrFail()` ni `$request->validate()`
- [ ] Ninguna firma quedó con route model binding (`show(Proyecto $proyecto)`)
- [ ] En `route:list` el parámetro dice `{id}`, no `{proyecto}`

### Regresión — que no se rompa lo que ya andaba
- [ ] `/` carga con estilos
- [ ] `/ingreso` loguea con `test@example.com` / `password`
- [ ] `/registro-proyecto` lista, crea, cambia el estado y elimina
- [ ] El `<select>` de estados sigue mostrando las 4 opciones
- [ ] `php artisan route:list` no tira errores

### Calidad (no puntúa, pero se nota)
- [ ] `vendor/bin/pint` corrido (formatea al estándar Laravel)
- [ ] `composer test` sin errores nuevos
- [ ] Capturas de Postman o del script guardadas para la entrega

---

## Formato de entrega

El PDF dice:

> *"Comprima los archivos y cualquier otro recurso que de su proyecto. El nombre a dar los
> archivos es el siguiente: **EV_U3_APELLIDO_NOMBRE**"*

### Qué incluir y qué no

| Incluir ✅ | Excluir ❌ | Por qué |
|---|---|---|
| `app/`, `routes/`, `config/`, `database/`, `resources/`, `bootstrap/`, `public/` | `vendor/` (~50 MB) | Se regenera con `composer install` |
| `composer.json`, `composer.lock` | `node_modules/` (~200 MB) | Se regenera con `npm install` |
| `package.json`, `package-lock.json`, `.env.example` | `.git/` | Historial, no hace falta |
| **`database/database.sqlite`** | `.env` | ⚠️ Tiene `APP_KEY` y `JWT_SECRET` |
| Capturas / colección de Postman | `storage/logs/*.log` | Ruido |

> 💡 **Incluí `database/database.sqlite` aunque esté en `.gitignore`.** Así el evaluador abre el
> proyecto y ya tiene usuarios (ids 1 y 2) para probar el `created_by` sin correr el seeder.

### Comando para armar el ZIP

```bash
cd /home/drayer/Proyectos

zip -r EV_U3_APELLIDO_NOMBRE.zip techsolutiongroups \
  -x "techsolutiongroups/vendor/*" \
  -x "techsolutiongroups/node_modules/*" \
  -x "techsolutiongroups/.git/*" \
  -x "techsolutiongroups/storage/logs/*" \
  -x "techsolutiongroups/storage/framework/cache/*" \
  -x "techsolutiongroups/storage/framework/sessions/*" \
  -x "techsolutiongroups/storage/framework/views/*" \
  -x "techsolutiongroups/public/build/*" \
  -x "techsolutiongroups/.env"

# Verificá el tamaño y el contenido antes de subirlo
ls -lh EV_U3_APELLIDO_NOMBRE.zip
unzip -l EV_U3_APELLIDO_NOMBRE.zip | grep -E "Api/ProyectoController|routes/api.php|database.sqlite"
```

Reemplazá `APELLIDO_NOMBRE` por los tuyos, **en mayúsculas y sin tildes ni espacios**.

### Antes de comprimir, dejá el proyecto limpio

```bash
cd /home/drayer/Proyectos/techsolutiongroups
php artisan optimize:clear     # borra caches de config, rutas y vistas
vendor/bin/pint                # formatea el código al estándar Laravel
```

### Sumá un `LEEME-API.md` en la raíz del proyecto

Media página para que el evaluador pruebe en 30 segundos:

```markdown
# API REST de Proyectos — Evaluación U3

## Levantar
composer install
npm install
npm run build                   # IMPRESCINDIBLE: sin esto la web tira 500 (la API anda igual)
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
php artisan migrate --seed      # (la base ya viene incluida; esto es por si querés partir limpio)
php artisan serve

## Idiomas
Responde en español por defecto y en inglés si el navegador lo pide
(cabecera Accept-Language). Para forzarlo: agregá ?lang=en o ?lang=es a la URL.

## Endpoints  (base: http://127.0.0.1:8000/api)

| Método | Ruta | Éxito | Errores |
|---|---|---|---|
| POST | /proyectos | 201 | 422 validación |
| GET | /proyectos | 200 (`data: []` si está vacía) | — |
| GET | /proyectos/{id} | 200 | 404 |
| PUT / PATCH | /proyectos/{id} | 200 | 404, 422 |
| DELETE | /proyectos/{id} | 200 | 404 |

Headers: `Accept: application/json` · `Content-Type: application/json`

Todas las respuestas usan el mismo envoltorio:
`{ "ok": bool, "codigo": int, "endpoint": string, "mensaje": string, "data": ... }`
Los 422 agregan `"errores"` con el detalle campo por campo.

## Cuerpo de ejemplo para el POST
​```json
{
  "nombre": "Cableado sucursal centro",
  "fecha_inicio": "2026-10-01",
  "estado": "pendiente",
  "responsable": "Nombre Apellido",
  "monto": 1500000,
  "created_by": 1
}
​```
Estados válidos: `pendiente`, `en_curso`, `finalizado`, `cancelado`.
Usuarios existentes para `created_by`: **1** y **2**.
```

---

## Cómo repartir el trabajo

> ⚠️ **Primero, un aviso que hay que confirmar con el profesor.** El PDF dice: *"Esta es una
> actividad calificada de la unidad y es de carácter **individual**"*. Si eso se mantiene, cada
> uno tiene que hacer **su propia entrega completa**, y este reparto sirve solamente para
> repartir el *estudio* del problema, no la nota. Coordinen esto antes de dividir nada.

### El equipo

| Persona | Bloque | Archivos que toca | Estado |
|---|---|---|---|
| **Drayer** | Base + Listar + Insertar + Idiomas | `Proyecto.php`, `ProyectoController.php` (web), `Api/ProyectoController.php` (`index`, `store`), `lang/`, `SetLocale.php`, `config/app.php`, `bootstrap/app.php`, `routes/api.php` (2 rutas) | ✅ Hecho |
| **Pipe** | Consultar por id + Actualizar | `Api/ProyectoController.php`: `show()` y `update()` | ⏳ |
| **Luisa** | Eliminar + Rutas + Cierre | `Api/ProyectoController.php`: `destroy()`; `routes/api.php`; `bootstrap/app.php` | ⏳ |

---

### 🟦 Drayer — ✅ terminado

Queda documentado para que se entienda de dónde salió cada cosa:

1. **Paso 2** — `ESTADOS` movido al modelo como `public const`, y el controlador web pasado a
   `Proyecto::ESTADOS`.
2. **Validaciones nuevas en el alta web** — `min:5` en `nombre` y `after_or_equal:2010-01-01`
   en `fecha_inicio`.
3. **Esqueleto de `Api/ProyectoController`** — los 6 `use`, el docblock de la clase y los 5
   métodos con la firma correcta (`$id`, no `Proyecto $proyecto`).
4. **`index()`** y **`store()`** completos.
5. **Sistema de idiomas** — `lang/es/`, `lang/en/`, `lang/en.json`, el middleware `SetLocale`,
   `supported_locales` en la config y el registro en `bootstrap/app.php`.
6. **Sus 2 rutas** en `routes/api.php`.

---

### 🟩 Pipe — `show()` y `update()`

**Antes de escribir nada, leé la [sección 7](#7-los-mensajes-en-dos-idiomas--es--en).** Es corta
y te evita el error más probable.

1. **`show($id)`** — Requerimiento 3. Código completo en [3.2](#32-contenido-completo).
2. **`update(Request $request, $id)`** — Requerimiento 4. Es `show()` + validación con
   `sometimes|required` + `fill()` + el `created_by` aparte + `refresh()`. El método más
   delicado de los cinco.
3. Pruebas **2.3 / 2.4** y **3.1 a 3.4** del Paso 6.

⏱️ ~45 min

📌 **Cuatro cosas para no romper:**

- **`Validator::make()` con DOS argumentos.** Si le pasás un array de mensajes como tercero,
  pisás `lang/` y la API responde siempre en un solo idioma.
- **El bloque del 404 tiene que ser idéntico** al de `destroy()`. Copialo de
  [3.2](#32-contenido-completo).
- **`$request->method()`** para el `endpoint` de `update()`, así la respuesta dice si entró por
  PUT o por PATCH. Es lo que se prueba en 3.1 vs 3.2.
- **No toques los `use` de arriba del archivo.** Ya están todos. Si los editás a la vez que
  Luisa, Git da conflicto.

---

### 🟨 Luisa — `destroy()`, rutas y cierre

**El Paso 4 no depende de que Pipe termine.** Hacelo primero: hasta que las 4 rutas existan,
nadie puede probar `show`, `update` ni `destroy` con Postman.

1. **Paso 4** — las 4 rutas que faltan. **Esto desbloquea las pruebas de todo el equipo.**
2. **`destroy($id)`** — Requerimiento 5. Código completo en [3.2](#32-contenido-completo).
3. **Paso 5** (opcional) — el 404 con formato propio para rutas inexistentes.
4. Pruebas **4.1 a 4.3** + el script `probar-api.fish` completo.
5. `LEEME-API.md`, colección de Postman y el ZIP de entrega.

⏱️ ~50 min

📌 **Dos trampas:**

- **Las rutas van en `routes/api.php`.** En `web.php` rompen el proyecto entero — ver
  [4.0](#40-van-en-routesapiphp-nunca-en-routeswebphp).
- **`{id}`, no `{proyecto}`.** El nombre del parámetro de la ruta tiene que coincidir con el de
  la variable del método.

---

### Orden de merge

```
Drayer  ✅ base + index + store + lang/ + 2 rutas
             │
             ├──────────────────┐
             ▼                  ▼
    Luisa (4 rutas)      Pipe (show + update)
             │                  │
             ▼                  │
    Luisa (destroy)             │
             └────────┬─────────┘
                      ▼
          Luisa (paso 5 + entrega)
```

**Pipe y Luisa tocan el mismo archivo pero métodos distintos**, así que Git mergea solo. Lo
único que genera conflicto es que dos personas toquen los `use` de arriba o el docblock de la
clase — por eso los escribió Drayer una sola vez, completos.

> Que cada uno trabaje en su rama (`feature/api-show-update`, `feature/api-destroy-rutas`) y
> mergee a `dev`.

### Commits sugeridos

```bash
# Drayer — ya hechos
git commit -m "refactor(proyectos): mover ESTADOS al modelo como constante publica"
git commit -m "feat(proyectos): validar nombre min 5 y fecha desde 2010 en el alta web"
git commit -m "feat(api): esqueleto de Api/ProyectoController con los 5 metodos"
git commit -m "feat(api): GET /api/proyectos con envoltorio ok/codigo/endpoint/mensaje"
git commit -m "feat(api): POST /api/proyectos con validaciones y respuesta 201"
git commit -m "feat(i18n): mensajes en espanol e ingles con middleware SetLocale"
git commit -m "feat(api): rutas de index y store en routes/api.php"

# Luisa
git commit -m "feat(api): rutas de show, update y destroy en routes/api.php"
git commit -m "feat(api): DELETE /api/proyectos/{id} con 200 y mensaje de confirmacion"

# Pipe
git commit -m "feat(api): GET /api/proyectos/{id} con 200 y 404 explicito"
git commit -m "feat(api): PUT/PATCH /api/proyectos/{id} con 200, 404 y 422"

# Luisa (cierre)
git commit -m "chore(api): 404 con formato propio para rutas inexistentes y LEEME-API.md"
```

---

## Solución de problemas

### ❌ `Cannot use ... as ProyectoController because the name is already in use`

**Ya nos pasó y dejó el proyecto entero sin arrancar.** El mensaje completo:

```
Cannot use App\Http\Controllers\Api\ProyectoController as ProyectoController
because the name is already in use   —  routes/web.php:8
```

Alguien puso las rutas de la API en `routes/web.php`, que ya importa el controlador **web** con
el mismo nombre corto. Un `use` importa el nombre corto, y PHP no admite dos `ProyectoController`
en el mismo archivo.

**Arreglo:** sacar de `routes/web.php` el `use App\Http\Controllers\Api\ProyectoController;`
y las rutas de proyectos que hayan quedado al final, y ponerlas en `routes/api.php`. Si el
archivo quedó revuelto y no tenía cambios propios:

```bash
git checkout -- routes/web.php
```

El razonamiento completo (y los otros dos motivos para no usar `web.php`) está en
[4.0](#40-van-en-routesapiphp-nunca-en-routeswebphp).

---

### ❌ Todas las páginas web dan **500** (`ViteManifestNotFoundException`)

```
Vite manifest not found at: .../public/build/manifest.json
```

**No tiene nada que ver con la API** — de hecho la API sigue funcionando perfecto. Falta
compilar el frontend: las vistas usan `@vite(...)` y `public/build/` está en `.gitignore`, así
que no viene en el repositorio.

```bash
npm install
npm run build      # una vez, y listo
```

O `npm run dev` en otra terminal si querés recarga en vivo mientras trabajás.

> Es el primer susto de cualquiera que clona el repo: parece que rompiste el sitio y en
> realidad solo faltan los assets compilados.

---

### ❌ La API devuelve HTML en vez de JSON

Falta la línea `shouldRenderJsonWhen` en `bootstrap/app.php`. **Ya está en el proyecto** —
verificá que no la hayas borrado al editar el archivo en el [Paso 5](#paso-5--404-de-rutas-inexistentes-opcional):

```php
$exceptions->shouldRenderJsonWhen(
    fn (Request $request) => $request->is('api/*'),
);
```

Mientras tanto, mandá siempre el header `Accept: application/json` en las pruebas.

---

### ❌ `POST` devuelve **200** en vez de **201**

Te falta el segundo argumento de `response()->json()`:

```php
return response()->json(['ok' => true, 'data' => $proyecto]);         // ❌ 200
return response()->json(['ok' => true, 'data' => $proyecto], 201);    // ✅ 201
```

Es el error que cuesta 4 puntos del indicador 1. Y acordate de que el `201` va **dos veces**:
como segundo argumento de `json()` y dentro del cuerpo, en la clave `'codigo'`. Si no coinciden,
la captura de Postman se contradice a sí misma.

---

### ❌ `DELETE` devuelve **204** y en Postman no se ve nada

No es un error: `noContent()` es la versión de la rúbrica original, y un `204` **no lleva
cuerpo por definición**, así que Postman muestra la respuesta vacía.

Nuestra versión devuelve **200 con mensaje de confirmación**:

```php
return response()->noContent();                                    // 204 vacío (versión PDF)

return response()->json([                                          // ✅ lo que usamos
    'ok'       => true,
    'codigo'   => 200,
    'endpoint' => 'DELETE /api/proyectos/'.$id,
    'mensaje'  => 'Proyecto "'.$nombre.'" eliminado correctamente.',
    'data'     => null,
], 200);
```

Las dos son defendibles; lo que **no** se puede es que Luisa devuelva 200 y el resto de la
documentación diga 204. Si cambian de opinión, hay que tocar también el script
`probar-api.fish`, el checklist y el `LEEME-API.md`.

---

### ❌ `GET /api/proyectos` con la tabla vacía devuelve `"data": {}` en vez de `"data": []`

Estás serializando un objeto en vez de una colección. Revisá que `index()` use `->get()`
(devuelve `Collection`) y no `->first()` ni `->paginate()`.

> Recordá que en nuestra versión el arreglo va **adentro de `data`**, no como respuesta
> completa: `{"ok":true,...,"total":0,"data":[]}`. El PDF pedía el `[]` pelado; es el desvío
> consciente de [3.0](#30-estilo-de-las-respuestas--leer-antes-de-escribir-código). Para
> revertirlo, `index()` termina en `return response()->json($proyectos, 200);` y listo.

---

### ❌ Un id inexistente devuelve **500** en vez de **404**

Tres causas posibles, en orden de probabilidad:

1. **Te falta el `if`.** Con `find()` el 404 **no es automático**: devuelve `null` y seguís
   ejecutando. La línea siguiente hace `$proyecto->nombre` sobre `null` y eso es un 500.
   ```php
   $proyecto = Proyecto::find($id);

   if ($proyecto === null) {          // ✅ sin este if, el 500 es inevitable
       return response()->json([...], 404);
   }
   ```
2. **Usaste `findOrFail()` en vez de `find()`.** `findOrFail()` lanza
   `ModelNotFoundException`; Laravel la convierte en 404, pero con **su** cuerpo (nombre de la
   clase del modelo + stack trace si `APP_DEBUG=true`), no con el nuestro. El código sale bien,
   el JSON no.
3. **El nombre del parámetro no coincide.** En `Route::get('/proyectos/{id}', ...)` el
   parámetro se llama `{id}`, así que la variable del método tiene que llamarse `$id`. Si en la
   ruta pusiste `{proyecto}` y en el método `$id`, llega `null` y `find(null)` no encuentra
   nada: todos los ids darían 404, incluso los que existen.

---

### ❌ `POST` con un `created_by` inexistente devuelve **500**

Falta la regla `exists`. Sin ella, el INSERT viola la clave foránea
(`proyectos.created_by → usuarios.id`, con `restrictOnDelete`) y SQLite lanza una
`QueryException` que termina en 500.

```php
'created_by' => ['required', 'integer', 'exists:usuarios,id'],   // ✅
```

---

### ❌ `Add [created_by] to fillable property to allow mass assignment`

Estás usando `Proyecto::create($datos)` con `created_by` adentro, y esa columna **no está en
`$fillable`** (queda fuera a propósito). Usá el patrón del [Paso 3](#paso-3--apiproyectocontroller-el-archivo-central):

```php
$proyecto = new Proyecto();
$proyecto->fill($datos);                       // solo los 5 campos fillable
$proyecto->created_by = $datos['created_by'];  // el 6º, explícito
$proyecto->save();
```

**No agregues `created_by` a `$fillable`**: debilitaría la protección del formulario web.

---

### ❌ `Class "App\Http\Controllers\Api\ProyectoController" not found`

El `use` de `routes/api.php` apunta al controlador equivocado. Tiene que ser el de `Api\`:

```php
use App\Http\Controllers\Api\ProyectoController;   // ✅ el nuevo
use App\Http\Controllers\ProyectoController;       // ❌ el web, devuelve redirects
```

Si el error persiste:

```bash
composer dump-autoload
php artisan optimize:clear
```

---

### ❌ En `route:list` aparecen rutas `create` y `edit`

Usaste `Route::resource(...)` en algún lado. Con las 6 rutas escritas una por una
([4.1](#41-routesapiphp--lo-que-ya-está)) esto no puede pasar; si igual aparecen, revisá que
no haya quedado una línea `Route::resource` o `Route::apiResource` de una versión anterior del
archivo. La API no tiene formularios, así que `create` y `edit` no van.

---

### ❌ `419 Page Expired` o errores de CSRF

Estás pegándole a una ruta de `routes/web.php`, no de `routes/api.php`. Las rutas web llevan
`VerifyCsrfToken`; las de API no. Revisá que la URL empiece con **`/api/`**.

---

### ❌ Cambié `routes/api.php` y no se ve el cambio

```bash
php artisan optimize:clear
```

Es el primer reflejo ante cualquier cosa rara, igual que dice la guía de instalación.

---

### ❌ `Auth guard [api] is not defined` (al probar `/api/me`)

Caché vieja de configuración. `config/auth.php` ya trae el guard `api`.

```bash
php artisan config:clear
```

---

### ❌ Los mensajes salen siempre en español, aunque pida inglés

Le pasaste un **tercer argumento** a `Validator::make()`. Ese array pisa los archivos de
`lang/`:

```php
$validador = Validator::make($request->all(), $reglas, $mensajes);   // ❌ los 3 argumentos
$validador = Validator::make($request->all(), $reglas);              // ✅ solo 2
```

Ver [7.4](#74--la-regla-que-no-hay-que-romper). Si el que sale en español es el `mensaje` del
envoltorio (no los `errores`), es al revés: te falta envolverlo en `__()`, o falta la
traducción en `lang/en.json` — ver [7.5](#75-cómo-agregar-una-frase-nueva).

---

### ❌ Un campo sale como "fecha inicio" en vez de "fecha de inicio"

Falta la entrada en el bloque `attributes` de `lang/es/validation.php`. Laravel, sin eso, solo
cambia el guion bajo por un espacio:

```php
'attributes' => [
    'fecha_inicio' => 'fecha de inicio',
    'created_by' => 'usuario creador',
],
```

---

### ❌ El `<select>` de estados quedó vacío en `/registro-proyecto`

Moviste la constante al modelo pero no actualizaste las referencias del controlador web.
Revisá el [Paso 2.2](#22-apphttpcontrollersproyectocontrollerphp-web--5-reemplazos):
tienen que ser 4 cambios de `self::ESTADOS` a `Proyecto::ESTADOS`.

---

## Apéndice A — Mejoras opcionales (fuera de rúbrica)

**Nada de esto suma puntos en la Unidad 3.** Está acá por dos motivos: para responder si el
profesor pregunta, y porque probablemente sea el contenido de la unidad siguiente.

> 🚨 **Consejo:** no implementes nada de este apéndice **antes** de tener las 13 pruebas del
> [Paso 6](#paso-6--probar-los-4-indicadores-de-la-rúbrica) en verde. Cada agregado es una
> oportunidad de romper un código HTTP que sí puntúa.

### A.1. Proteger el CRUD con JWT (1 línea)

El middleware ya existe y funciona. Envolvé las 6 rutas:

```php
Route::middleware('jwt.custom')->group(function () {
    Route::get('/proyectos', [ProyectoController::class, 'index']);
    // ... y las otras 5
});
```

Y entonces `created_by` y `responsable` salen del token en vez del request:

```php
$proyecto->created_by  = $request->user()->id;
$proyecto->responsable = $request->user()->nombre;
```

⚠️ Si hacés esto, **sacá `created_by` y `responsable` de las reglas de validación** — dejarían
de ser campos del request y el POST fallaría con 422. Y acordate de que el evaluador va a
necesitar un token: agregá al `LEEME-API.md` cómo obtenerlo.

### A.2. Endpoint de login para obtener el token por HTTP

Hoy el token solo se saca con `php artisan tinker`. Un `POST /api/login` lo arregla:

```php
// app/Http/Controllers/Api/AuthController.php
public function login(Request $request): JsonResponse
{
    $datos = $request->validate([
        'correo' => ['required', 'email'],
        'clave'  => ['required', 'string'],
    ]);

    // La clave del array tiene que llamarse 'password' aunque la columna sea
    // 'clave': EloquentUserProvider ignora las claves que contienen "password"
    // al armar el WHERE, y compara contra getAuthPassword(), que el modelo
    // Usuario redirige a la columna 'clave' vía getAuthPasswordName().
    $token = auth('api')->attempt([
        'correo'   => $datos['correo'],
        'password' => $datos['clave'],
    ]);

    if (! $token) {
        return response()->json(['message' => 'Credenciales incorrectas.'], 401);
    }

    return response()->json([
        'access_token' => $token,
        'token_type'   => 'bearer',
        'expires_in'   => auth('api')->factory()->getTTL() * 60,
    ]);
}
```

Para `logout` y `refresh` hace falta publicar `config/jwt.php` y poner
`JWT_BLACKLIST_ENABLED=true` en el `.env`:

```bash
php artisan vendor:publish --provider="PHPOpenSourceSaver\JWTAuth\Providers\LaravelServiceProvider"
```

### A.3. Form Requests (sacar la validación del controlador)

```bash
php artisan make:request Api/ProyectoStoreRequest
```

Movés el array de reglas a `rules()` y el controlador queda en 4 líneas. **Es más prolijo, pero
la rúbrica solo pide que la validación exista** — y con el array inline se ve más rápido en una
revisión de código.

### A.4. API Resources

Permiten elegir qué campos salen y agregar campos calculados (`estado_legible`, `imagen_url`).
**No los uses en esta entrega:** envuelven la respuesta en `{"data": …}` y el enunciado pide
*"un arreglo vacío"* y *"todos los campos"*.

### A.5. Policy: que cada usuario solo toque sus proyectos

Hoy la regla está copiada a mano en `ProyectoController` (web):

```php
abort_unless((int) $proyecto->created_by === (int) $request->user()->id, 403);
```

Con `php artisan make:policy ProyectoPolicy --model=Proyecto` la centralizás y usás
`$this->authorize('update', $proyecto)`.

⚠️ Requiere agregar el trait `AuthorizesRequests` a `app/Http/Controllers/Controller.php`, que
en Laravel 11+ viene **vacío**:

```php
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller
{
    use AuthorizesRequests;
}
```

Sin eso: `Call to undefined method authorize()`.

### A.6. Paginación y filtros

`->paginate(15)` en vez de `->get()`, con `?estado=`, `?buscar=` y `?per_page=`.
**Incompatible con el requisito del arreglo vacío**, así que sería un endpoint aparte
(`GET /api/proyectos/buscar`) o una unidad posterior.

### A.7. Tests automatizados

`phpunit.xml` ya está configurado con SQLite `:memory:`, así que los tests no tocan tu base.
Falta crear `database/factories/` (hoy no existe) y agregar `use HasFactory;` a los modelos.

```php
public function test_store_devuelve_201(): void
{
    $usuario = Usuario::factory()->create();

    $this->postJson('/api/proyectos', [
        'nombre' => 'Test', 'fecha_inicio' => '2026-10-01', 'estado' => 'pendiente',
        'responsable' => 'QA', 'monto' => 1000, 'created_by' => $usuario->id,
    ])->assertCreated();          // 201
}

public function test_index_devuelve_data_vacia(): void
{
    $this->getJson('/api/proyectos')
        ->assertOk()                       // 200
        ->assertJsonPath('total', 0)
        ->assertJsonPath('data', []);
}

public function test_destroy_devuelve_200_con_mensaje(): void
{
    $proyecto = Proyecto::factory()->create();

    $this->deleteJson("/api/proyectos/{$proyecto->id}")
        ->assertOk()                       // 200
        ->assertJsonPath('ok', true)
        ->assertJsonPath('codigo', 200);
}

public function test_show_de_id_inexistente_devuelve_404_propio(): void
{
    $this->getJson('/api/proyectos/99999')
        ->assertNotFound()                 // 404
        ->assertJsonPath('ok', false)
        ->assertJsonMissingPath('exception');   // sin stack trace
}
```

### A.8. Mejoras pendientes en `JwtMiddleware` (opcional)

El archivo `app/Http/Middleware/JwtMiddleware.php` **funciona correctamente** tal como está
commiteado: devuelve `401` sin token, `401` con token inválido y `200` con token válido
(comprobado, ver [4.3.a](#43-dos-cosas-que-encontré-de-paso-no-son-parte-de-la-evaluación)).

Tiene tres detalles de estilo que **no rompen nada** pero conviene conocer. **No los toques para
la entrega de la U3** — este middleware no interviene en el CRUD evaluado.

**1. El namespace `JWTauth` está mal escrito.**

```php
use PHPOpenSourceSaver\JWTauth\Exceptions\TokenExpiredException;   // ← 'JWTauth', a minúscula
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;            // ← 'JWTAuth', correcto
```

El namespace real del paquete es `PHPOpenSourceSaver\JWTAuth\`. **Funciona igual** porque los
nombres de clase en PHP son insensibles a mayúsculas: cuando el paquete lanza la excepción, la
clase ya quedó cargada con su nombre correcto, y el `catch` la encuentra por comparación en
minúsculas. Pero es frágil y confunde al IDE. Arreglo:

```php
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
```

**2. Los códigos de estado van como string.**

```php
return response()->json(['error' => 'Token Expirado'], '401');   // '401' entre comillas
```

PHP convierte `'401'` a `401` sola, así que la respuesta sale bien. Pero lo correcto es el
entero sin comillas: `401`. *(Este archivo es de la U2 y no sigue el envoltorio de la U3; si
alguna vez lo unificamos, iría con las mismas 5 claves que el resto.)*

**3. Falta capturar `TokenBlacklistedException`.**

Solo importa si algún día implementás `logout` con lista negra ([A.2](#a2-endpoint-de-login-para-obtener-el-token-por-http)).
Como esa clase **extiende** `TokenInvalidException`, hoy cae en ese `catch` y devuelve
*"Token Invalido"*, que es correcto aunque poco específico. Si lo agregás, tiene que ir
**antes** de `TokenInvalidException`:

```php
} catch (TokenExpiredException $e) {
    return response()->json(['error' => 'Token Expirado'], 401);
} catch (TokenBlacklistedException $e) {     // ← ANTES que TokenInvalid: es su hija
    return response()->json(['error' => 'Sesión cerrada'], 401);
} catch (TokenInvalidException $e) {
    return response()->json(['error' => 'Token Invalido'], 401);
} catch (JWTException $e) {                  // ← SIEMPRE al final: es la clase padre
    return response()->json(['error' => 'Token Ausente'], 401);
}
```

> **Por qué el orden importa.** La jerarquía es
> `JWTException` → `TokenInvalidException` → `TokenBlacklistedException`. PHP entra en el
> **primer** `catch` que coincida, así que si `JWTException` fuera primero, todos los errores
> dirían *"Token Ausente"*. El orden actual del archivo ya es el correcto.

---

### A.9. Otras cosas que quedaron fuera

| Mejora | Por qué no ahora |
|---|---|
| Versionado `/api/v1/` | Cambia todas las URLs del enunciado |
| Rate limiting (`throttleApi`) | En Laravel 11+ exige definir un `RateLimiter` en `AppServiceProvider`, y si te olvidás la app no arranca |
| CORS | Solo hace falta si consumís desde un frontend en otro origen |
| Endpoints de usuarios y productos | Ni el enunciado ni la rúbrica los mencionan |
| Mover los productos de `routes/web.php` a una tabla | Es refactor del código de la U1, no de la U3 |

---

## Apéndice B — Referencia rápida de la API

**Base:** `http://127.0.0.1:8000/api`
**Headers:** `Accept: application/json` · `Content-Type: application/json`
**Autenticación:** ninguna (ver [§5](#5-decisión-clave-la-api-lleva-token-o-no))

### Endpoints

| Método | Ruta | Éxito | Errores | Cuerpo de respuesta |
|---|---|---|---|---|
| `POST` | `/proyectos` | **201** | `422` | `data` = el proyecto creado |
| `GET` | `/proyectos` | **200** | — | `data` = arreglo de proyectos (`[]` si está vacío) + `total` |
| `GET` | `/proyectos/{id}` | **200** | `404` | `data` = el proyecto |
| `PUT` | `/proyectos/{id}` | **200** | `404`, `422` | `data` = el proyecto actualizado |
| `PATCH` | `/proyectos/{id}` | **200** | `404`, `422` | `data` = el proyecto actualizado |
| `DELETE` | `/proyectos/{id}` | **200** | `404` | `data` = `null`, con `mensaje` de confirmación |
| `GET` | `/me` | **200** | `401` | El usuario del token JWT *(sin envoltorio: es de la U2)* |

**Envoltorio común de los 6 primeros:**

| Clave | Siempre | Qué lleva |
|---|---|---|
| `ok` | ✅ | `true` / `false` |
| `codigo` | ✅ | el código HTTP repetido dentro del cuerpo |
| `endpoint` | ✅ | verbo + ruta que respondió, p. ej. `"PATCH /api/proyectos/7"` |
| `mensaje` | ✅ | explicación en español |
| `data` | ✅ | el/los proyecto(s), o `null` |
| `total` | solo `GET /proyectos` | cantidad de filas devueltas |
| `errores` | solo en `422` | detalle campo por campo |

### Campos de `proyectos`

| Campo | Tipo en la base | Reglas | Ejemplo |
|---|---|---|---|
| `id` | `bigint` auto | *(lo genera la base)* | `7` |
| `nombre` | `varchar(100)` | requerido, texto, máx. 100 | `"Cableado sucursal centro"` |
| `fecha_inicio` | `date` | requerido, fecha | `"2026-10-01"` |
| `estado` | `varchar(50)` | requerido, uno de los 4 válidos | `"pendiente"` |
| `responsable` | `varchar(100)` | requerido, texto, máx. 100 | `"Drayer Yoncley"` |
| `monto` | `unsignedInteger` | requerido, entero, 0 – 4294967295 | `1500000` |
| `created_by` | `bigint` FK → `usuarios.id` | requerido, entero, debe existir | `1` |
| `created_at` / `updated_at` | `timestamp` | *(automáticos)* | `"2026-09-04T16:20:00.000000Z"` |

**Estados válidos:** `pendiente` · `en_curso` · `finalizado` · `cancelado`
**Usuarios existentes hoy** (para `created_by`): **1** y **2**

### Ejemplo de POST

```json
{
  "nombre": "Cableado sucursal centro",
  "fecha_inicio": "2026-10-01",
  "estado": "pendiente",
  "responsable": "Drayer Yoncley",
  "monto": 1500000,
  "created_by": 1
}
```

### Ejemplo de respuesta 201

```json
{
  "ok": true,
  "codigo": 201,
  "endpoint": "POST /api/proyectos",
  "mensaje": "Proyecto creado correctamente.",
  "data": {
    "nombre": "Cableado sucursal centro",
    "fecha_inicio": "2026-10-01T00:00:00.000000Z",
    "estado": "pendiente",
    "responsable": "Drayer Yoncley",
    "monto": 1500000,
    "created_by": 1,
    "updated_at": "2026-09-04T16:20:00.000000Z",
    "created_at": "2026-09-04T16:20:00.000000Z",
    "id": 7
  }
}
```

### Ejemplo de respuesta 200 (listado)

```json
{
  "ok": true,
  "codigo": 200,
  "endpoint": "GET /api/proyectos",
  "mensaje": "Listado de proyectos obtenido correctamente.",
  "total": 0,
  "data": []
}
```

### Ejemplo de respuesta 404

```json
{
  "ok": false,
  "codigo": 404,
  "endpoint": "GET /api/proyectos/99999",
  "mensaje": "No existe un proyecto con el id 99999.",
  "data": null
}
```

### Ejemplo de respuesta 200 (DELETE)

```json
{
  "ok": true,
  "codigo": 200,
  "endpoint": "DELETE /api/proyectos/7",
  "mensaje": "Proyecto \"Cableado sucursal centro\" eliminado correctamente.",
  "data": null
}
```

> `fecha_inicio` sale con hora porque el modelo tiene el cast `'fecha_inicio' => 'date'`, que la
> convierte en un objeto `Carbon` y se serializa en ISO 8601. **Incluye el campo**, que es lo
> que pide el enunciado. Si querés que salga como `"2026-10-01"` a secas, cambiá el cast a
> `'date:Y-m-d'` en `app/Models/Proyecto.php`.

### Ejemplo de respuesta 422

```json
{
  "ok": false,
  "codigo": 422,
  "endpoint": "POST /api/proyectos",
  "mensaje": "No se pudo crear el proyecto: hay campos inválidos.",
  "errores": {
    "nombre":       ["El campo nombre es obligatorio y no puede estar vacío."],
    "fecha_inicio": ["El campo fecha inicio es obligatorio y no puede estar vacío."],
    "estado":       ["El campo estado es obligatorio y no puede estar vacío."],
    "responsable":  ["El campo responsable es obligatorio y no puede estar vacío."],
    "monto":        ["El campo monto es obligatorio y no puede estar vacío."],
    "created_by":   ["El campo created by es obligatorio y no puede estar vacío."]
  },
  "data": null
}
```

> La clave es **`errores`**, no `errors`: la armamos nosotros con `$validador->errors()` en vez
> de dejar que Laravel genere el 422 por su cuenta. Si en alguna respuesta ves `errors` (en
> inglés) y un `message` de primer nivel, ese método se quedó con `$request->validate()` y hay
> que pasarlo a `Validator::make()`.

### El mismo 422, en inglés

Con `?lang=en` o con la cabecera `Accept-Language: en-US,en;q=0.9`:

```json
{
  "ok": false,
  "codigo": 422,
  "endpoint": "POST /api/proyectos",
  "mensaje": "The project could not be created: some fields are invalid.",
  "errores": {
    "nombre":       ["The nombre field is required."],
    "fecha_inicio": ["The fecha inicio field is required."],
    "estado":       ["The estado field is required."],
    "responsable":  ["The responsable field is required."],
    "monto":        ["The monto field is required."],
    "created_by":   ["The created by field is required."]
  },
  "data": null
}
```

Fijate que en inglés los nombres de campo salen **sin traducir** (`fecha inicio`, `created by`):
el bloque `attributes` solo está cargado en `lang/es/validation.php`. Es una decisión
consciente — los campos se llaman así en la base de datos y en el JSON que manda el cliente, así
que en inglés conviene que coincidan. Si quisieran traducirlos, se agrega el mismo bloque
`attributes` en `lang/en/validation.php`.

---

## Resumen en una pantalla

| | Antes | Después |
|---|---|---|
| **Archivos nuevos** | — | 1 (`Api/ProyectoController.php`) |
| **Archivos modificados** | — | 3 (`Proyecto.php`, `ProyectoController.php` web, `routes/api.php`) + 1 opcional |
| **Endpoints de API** | 1 (`/api/me`) | 7 |
| **Verbos HTTP** | GET | GET, POST, PUT, PATCH, DELETE |
| **Códigos que devuelve** | 200, 401 | 200, 201, 404, 422 |
| **Idiomas** | 1 (inglés, el de Laravel) | 2 (español por defecto, inglés según el navegador) |
| **Personas** | — | 3 (Drayer · Pipe · Luisa) |
| **Avance** | — | 2 de 5 métodos + rutas + idiomas ✅ |
| **Migraciones nuevas** | — | 0 |
| **Paquetes nuevos** | — | 0 |
| **Cambios en las vistas** | — | 0 |
| **Puntaje objetivo** | — | **100 / 100** |

---

*Documento reescrito el 2026-09-04 a partir de `Evaluación de desarrollo o entrega_código.pdf`,
`Rúbrica_U3.pdf` y el análisis del código en `/home/drayer/Proyectos/techsolutiongroups`
(rama `main`, commit `d1a04db`). La versión anterior planteaba 21 endpoints; se redujo a 6 tras
comprobar que la rúbrica evalúa únicamente el CRUD de `proyectos` y sus códigos HTTP.*

*Actualizado el 2026-09-04 con dos cambios pedidos por el equipo: (1) el Paso 3 se reparte entre
**Drayer** (base, `index`, `store`), **Pipe** (`show`, `update`) y **Luisa** (`destroy`, rutas,
cierre); (2) los 5 métodos pasan a un estilo **clásico y explícito** — envoltorio JSON común con
`ok`/`codigo`/`endpoint`/`mensaje`/`data`, códigos numéricos literales, `find()` + `if` en lugar
de route model binding, `Validator::make()` en lugar de `$request->validate()` y rutas escritas
una por una. Los dos desvíos respecto de la letra del PDF (`index()` con la tabla vacía y
`destroy()` con 200 en vez de 204) están documentados en la sección 3.0 con su reversión de una
línea.*

*Segunda actualización del 2026-09-04, con el bloque de Drayer ya terminado y probado. Novedades:
(a) **[sección 7](#7-los-mensajes-en-dos-idiomas--es--en) nueva** — la aplicación responde en
español o inglés según el navegador, con `lang/es/`, `lang/en/`, `lang/en.json` y el middleware
`SetLocale`; (b) **el método `mensajes()` se eliminó** del controlador de API: sus textos ahora
viven en `lang/`, y `Validator::make()` va con dos argumentos, nunca tres; (c) **[Estado
actual](#-estado-actual-del-proyecto) nuevo** con lo hecho y lo pendiente por persona; (d) el
alta web suma `min:5` en `nombre` y `after_or_equal:2010-01-01` en `fecha_inicio`, y la API
replica las dos; (e) **[4.0](#40-van-en-routesapiphp-nunca-en-routeswebphp) nuevo** explicando
por qué las rutas no pueden ir en `routes/web.php` (nos costó un fatal error); (f) cuerpos de
Postman listos para copiar, con los mensajes verificados contra el servidor; (g) entradas nuevas
en Solución de problemas: la colisión de nombres en `web.php`, el `ViteManifestNotFoundException`
por no correr `npm run build`, y los dos errores típicos del sistema de idiomas.*
