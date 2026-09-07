<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Proyecto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OA;

/**
 * API REST del recurso "proyectos" — Evaluación Sumativa Unidad 3.
 *
 *   GET    /api/proyectos        → listar   → 200             · Drayer ✅
 *   POST   /api/proyectos        → crear    → 201 · 422       · Drayer ✅
 *   GET    /api/proyectos/{id}   → ver uno  → 200 · 404       · Pipe ✅
 *   PUT    /api/proyectos/{id}   → editar   → 200 · 404 · 422 · Pipe ✅
 *   PATCH  /api/proyectos/{id}   → editar   → 200 · 404 · 422 · Pipe ✅
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

// SOBRE CADA METODO DEBEMOS IMPLEMENTAR LOS @OA, ESTE INICIAL ES GLOBAL PARA DAR CUERPO Y DESCRIPCION DE NUESTRO SWAGGER.
// OJO, CADA NOTACION DE SWAGGER DEBE SER IMPLEMENTADA CON # ANTES DE CADA METODO, 
// NO DENTRO DE ELLOS, YA QUE SI SE IMPLEMENTA DENTRO, SWAGGER NO LO RECONOCE Y NO LO MUESTRA EN LA DOCUMENTACION.

#[OA\Info(
    version: "1.0.0",
    title: "API REST de proyectos",
    description: "API REST de proyectos para la Evaluación Sumativa Unidad 3"
)]
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

    #[OA\Get(
        path: "/api/proyectos",
        summary: "Listar todos los proyectos",
        tags: ["Proyectos"],
        responses: [
            new OA\Response(response: 200, description: "Listado de proyectos obtenido correctamente")
        ]
    )]
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
    {
        $proyecto = Proyecto::find($id);

        if ($proyecto === null) {
            return response()->json([
                'ok'=> false,
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
    } //si esto no explota es porque soy barbaro

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
    {
        $verbo = $request->method();

        $proyecto = Proyecto::find($id);

        if($proyecto === null){
            return response()->json([
                'ok' => false,
                'codigo' => 404,
                'endpoint' => $verbo.' /api/proyectos/'.$id,
                'mensaje' => __('No existe un proyecto con el id :id.', ['id' => $id]),
                'data' => null,
            ], 404);
        }
        
        $validador = Validator::make($request->all(), [
            'nombre' => ['sometimes', 'required', 'string', 'min:5', 'max:100'],
            'fecha_inicio' => ['sometimes', 'required', 'date', 'after_or_equal:2010-01-01'],
            'estado' => ['sometimes', 'required', Rule::in(array_keys(Proyecto::ESTADOS))],
            'responsable' => ['sometimes', 'required', 'string', 'max:100'],
            'monto' => ['sometimes', 'required', 'integer', 'min:0', 'max:4294967295'],
            'created_by' => ['sometimes', 'required', 'integer', 'exists:usuarios,id'],
        ]);

        if($validador->fails()) {
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

        if (array_key_exists('created_by', $datos)) {
            $proyecto->created_by = $datos['created_by'];
        }

        $proyecto->save();

        return response()->json([
            'ok' => true,
            'codigo' => 200,
            'endpoint' => $verbo.' /api/proyectos/'.$id,
            'mensaje' => __('Proyecto actualizado correctamente.'),
            'data' => $proyecto->refresh(),
        ], 200);
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
