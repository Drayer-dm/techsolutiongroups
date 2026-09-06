<?php

use App\Http\Controllers\Api\ProyectoController;
use Illuminate\Support\Facades\Route;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

/*
|--------------------------------------------------------------------------
| Rutas de la API — TechSolutionGroups
|--------------------------------------------------------------------------
|
| bootstrap/app.php carga este archivo con:
|     ->withRouting(api: __DIR__.'/../routes/api.php', ...)
|
| Eso antepone el prefijo /api a TODAS las rutas de acá automáticamente:
| Route::get('/proyectos', ...) se sirve en /api/proyectos.
|
| ⚠️ Estas rutas NO pueden ir en routes/web.php:
|   1. El nombre corto ProyectoController ya está tomado allá por el
|      controlador web, y PHP no admite dos "use" con el mismo nombre.
|   2. Sin el prefijo api/ los errores salen en HTML, no en JSON.
|   3. El grupo "web" agrega protección CSRF: un POST desde Postman daría 419.
|
*/

/*
|--------------------------------------------------------------------------
| CRUD de proyectos — Evaluación Sumativa Unidad 3
|--------------------------------------------------------------------------
|
| Por ahora solo los 2 endpoints de Drayer. Luisa completa los otros 4 en el
| Paso 4 de la guía (show, update con PUT y PATCH, y destroy).
|
*/

// REQUERIMIENTO 2 — listar todos      → 200
Route::get('/proyectos', [ProyectoController::class, 'index']);

// REQUERIMIENTO 1 — crear             → 201 · 422
Route::post('/proyectos', [ProyectoController::class, 'store']);

// REQUERIMIENTO 3 — mostrar uno      → 200 · 404
Route::get('/proyectos/{proyecto}', [ProyectoController::class, 'show']);

// REQUERIMIENTO 4 — actualizar uno   → 200 · 404 · 422
Route::put('/proyectos/{proyecto}', [ProyectoController::class, 'update']);
Route::patch('/proyectos/{proyecto}', [ProyectoController::class, 'update']);

/*
|--------------------------------------------------------------------------
| Endpoint JWT de la unidad anterior
|--------------------------------------------------------------------------
*/
Route::middleware('jwt.custom')->group(function () {
    Route::get('/me', function () {
        // Si el middleware dejó pasar, el token era válido y este user existe.
        return response()->json(JWTAuth::user());
    });
});
