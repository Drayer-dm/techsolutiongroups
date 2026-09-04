<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Proyecto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * API REST del recurso "proyectos" — Evaluación Sumativa Unidad 3.
 *
 *   GET    /api/proyectos        → listar   → 200             · Drayer ✅
 *   POST   /api/proyectos        → crear    → 201 · 422       · Drayer ✅
 *   GET    /api/proyectos/{id}   → ver uno  → 200 · 404       · Pipe ⏳
 *   PUT    /api/proyectos/{id}   → editar   → 200 · 404 · 422 · Pipe ⏳
 *   PATCH  /api/proyectos/{id}   → editar   → 200 · 404 · 422 · Pipe ⏳
 *   DELETE /api/proyectos/{id}   → eliminar → 200 · 404       · Luisa ⏳
 *
 * ── Estilo de las respuestas ──────────────────────────────────────────────
 * Los 5 métodos devuelven SIEMPRE la misma estructura:
 *
 *   ok        → true / false
 *   codigo    → el código HTTP repetido dentro del cuerpo
 *   endpoint  → el verbo + la ruta que respondió
 *   mensaje   → explicación de qué pasó
 *   data      → el o los proyectos, o null en los errores
 *   errores   → solo en los 422, el detalle campo por campo
 *
 * El 404 se maneja a mano (find() + if), no con route model binding, para que
 * el control del error quede a la vista dentro del controlador. La validación
 * usa Validator::make() por el mismo motivo: el 422 lo armamos nosotros.
 *
 * ⚠️ Los TEXTOS de los errores de validación no se escriben acá: salen de
 *    lang/es/validation.php y lang/en/validation.php, y App\Http\Middleware\
 *    SetLocale elige el idioma según el navegador. Por eso Validator::make()
 *    va con DOS argumentos: pasarle un array de mensajes como tercero pisaría
 *    las traducciones y la API respondería siempre en un solo idioma.
 *
 * Diferencias con App\Http\Controllers\ProyectoController (el de la web):
 *   · devuelve JSON, no redirect()->route() ni view()
 *   · devuelve códigos HTTP explícitos (200, 201, 404, 422)
 *   · no usa sesión ni mensajes flash: la API es stateless
 *   · recibe created_by y responsable en el request, en vez de sacarlos del
 *     usuario logueado (el enunciado pide que TODOS los campos sean requeridos)
 */
class ProyectoController extends Controller
{
    /**
     * REQUERIMIENTO 2 — Búsqueda de todos los proyectos.
     *
     *   GET /api/proyectos   → 200
     *
     * ✔ "La respuesta debe incluir todos los campos"
     *    → devolvemos el modelo entero, sin API Resource que filtre columnas.
     * ✔ "El código de respuesta debe ser 200".
     *
     * ⚠️ NO uses ->paginate(): envolvería el listado en data/links/meta y
     *    perderíamos el control del formato de la respuesta.
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

    /**
     * REQUERIMIENTO 1 — Agregar un proyecto.
     *
     *   POST /api/proyectos   → 201 · 422
     *
     * ✔ "Todos los campos son requeridos y no deben estar vacíos"
     *    → los 6 campos llevan 'required'. En Laravel, 'required' rechaza null,
     *      cadena vacía, arreglo vacío y archivo vacío: es exactamente
     *      "requerido y no vacío".
     * ✔ "El código de respuesta debe ser 201"
     *    → el 201 va explícito. Si dejáramos response()->json($proyecto) a
     *      secas devolvería 200 y perderíamos puntos en la rúbrica.
     */
    public function store(Request $request): JsonResponse
    {
        // Validator::make() NO lanza excepción: devuelve un objeto que se
        // consulta con fails(). Así el 422 lo devolvemos nosotros, con el mismo
        // envoltorio que el resto de las respuestas.
        $validador = Validator::make($request->all(), [
            // nombre: varchar(100) en la migración. El mínimo de 5 caracteres
            // es la misma regla que usa el formulario web, para que no haya dos
            // criterios distintos según por dónde entren los datos.
            'nombre' => ['required', 'string', 'min:5', 'max:100'],

            // fecha_inicio: columna DATE. El piso de 2010 descarta fechas
            // cargadas por error (1970, 0001, etc.), igual que en la web.
            'fecha_inicio' => ['required', 'date', 'after_or_equal:2010-01-01'],

            // estado: varchar(50), pero solo aceptamos las 4 claves válidas.
            // Rule::in() lee la constante del modelo, así que la web y la API
            // nunca se desincronizan.
            'estado' => ['required', Rule::in(array_keys(Proyecto::ESTADOS))],

            // responsable: varchar(100).
            'responsable' => ['required', 'string', 'max:100'],

            // monto: unsignedInteger → entero, sin signo, máximo 4.294.967.295
            // (el tope de un INT de 4 bytes sin signo). Sin el 'max', un número
            // más grande lo trunca la base en silencio.
            'monto' => ['required', 'integer', 'min:0', 'max:4294967295'],

            // created_by: FK a usuarios. 'exists' verifica que el usuario exista
            // ANTES de intentar el INSERT; sin esta regla, un id inventado
            // reventaría con un 500 por violación de clave foránea.
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

        // validated() devuelve SOLO los campos que pasaron por las reglas.
        // Nunca uses $request->all() para guardar: entraría cualquier campo
        // extra que el cliente haya mandado de más.
        $datos = $validador->validated();

        // Se crea con fill() + save() en vez de Proyecto::create() porque
        // created_by NO está en $fillable del modelo (queda fuera a propósito,
        // para que el formulario web no lo pueda falsear por asignación masiva).
        // Asignarlo como propiedad esquiva $fillable sin debilitarlo.
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

    /**
     * REQUERIMIENTO 3 — Búsqueda de un proyecto por su ID.   ⏳ LE TOCA A PIPE
     *
     *   GET /api/proyectos/{id}   → 200 · 404
     *
     * Pasos: Proyecto::find($id) · if ($proyecto === null) → 404 · si no → 200
     * con el proyecto en 'data'.
     *
     * El bloque del 404 tiene que quedar IDÉNTICO al de update() y destroy():
     * copialo, no lo reescribas de memoria.
     */
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

    /**
     * REQUERIMIENTO 4 — Actualizar un proyecto por su ID.    ⏳ LE TOCA A PIPE
     *
     *   PUT   /api/proyectos/{id}   → 200 · 404 · 422
     *   PATCH /api/proyectos/{id}   → 200 · 404 · 422
     *
     * Pasos: find() + if 404 · Validator con 'sometimes','required' en los 6
     * campos (eso es lo que permite el PATCH parcial) · fill() · created_by
     * aparte con array_key_exists() · save() · 200 con $proyecto->refresh().
     *
     * Usá $request->method() para armar el 'endpoint', así la respuesta dice si
     * entró por PUT o por PATCH.
     */
    public function update(Request $request, $id): JsonResponse
    {
        return response()->json([
            'ok' => false,
            'codigo' => 501,
            'endpoint' => $request->method().' /api/proyectos/'.$id,
            'mensaje' => 'Endpoint todavía no implementado.',
            'data' => null,
        ], 501);
    }

    /**
     * REQUERIMIENTO 5 — Eliminar un proyecto por su ID.     ⏳ LE TOCA A LUISA
     *
     *   DELETE /api/proyectos/{id}   → 200 · 404
     *
     * Pasos: find() + if 404 · guardar el nombre en una variable · delete() ·
     * 200 con el mensaje de confirmación y 'data' => null.
     */
    public function destroy($id): JsonResponse
    {
        return response()->json([
            'ok' => false,
            'codigo' => 501,
            'endpoint' => 'DELETE /api/proyectos/'.$id,
            'mensaje' => 'Endpoint todavía no implementado.',
            'data' => null,
        ], 501);
    }
}
