<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProyectoController extends Controller
{
    /**
     * Estados posibles de un proyecto.
     * La misma lista alimenta los <select> de la vista y la validacion,
     * asi no se pueden desincronizar.
     */
    private const ESTADOS = [
        'pendiente'  => 'Pendiente',
        'en_curso'   => 'En curso',
        'finalizado' => 'Finalizado',
        'cancelado'  => 'Cancelado',
    ];

    /**
     * Pagina "Mis Proyectos": formulario arriba, listado abajo.
     */
    public function index(Request $request): View
    {
        return view('registro-proyecto', [
            'estados'   => self::ESTADOS,
            'proyectos' => $request->user()->proyectos()->latest()->get(),
        ]);
    }

    /**
     * Guarda el proyecto a nombre del usuario con sesion iniciada.
     */
    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'nombre'       => ['required', 'string', 'max:100'],
            'fecha_inicio' => ['required', 'date'],
            'estado'       => ['required', Rule::in(array_keys(self::ESTADOS))],
            'monto'        => ['required', 'integer', 'min:0', 'max:4294967295'],
        ]);

        // El responsable es siempre el dueño de la cuenta: no viene del formulario,
        // lo pone el servidor igual que created_by. Como usuarios.nombre es de 70
        // caracteres y proyectos.responsable de 100, siempre cabe.
        $datos['responsable'] = $request->user()->nombre;

        // La relacion pone created_by sola, con el id de la sesion.
        $proyecto = $request->user()->proyectos()->create($datos);

        return redirect()->route('registro-proyecto.index')
            ->with('status', "Proyecto \"{$proyecto->nombre}\" registrado correctamente.");
    }

    /**
     * Cambia solo el estado del proyecto (PATCH).
     */
    public function update(Request $request, Proyecto $proyecto): RedirectResponse
    {
        // Sin esto, cualquiera edita proyectos ajenos cambiando el id de la URL.
        abort_unless((int) $proyecto->created_by === (int) $request->user()->id, 403);

        $datos = $request->validate([
            'estado' => ['required', Rule::in(array_keys(self::ESTADOS))],
        ]);

        $proyecto->update($datos);

        return redirect()->route('registro-proyecto.index')
            ->with('status', "Estado de \"{$proyecto->nombre}\" actualizado a "
                . self::ESTADOS[$proyecto->estado] . '.');
    }

    /**
     * Elimina el proyecto (DELETE).
     */
    public function destroy(Request $request, Proyecto $proyecto): RedirectResponse
    {
        abort_unless((int) $proyecto->created_by === (int) $request->user()->id, 403);

        // Guardamos el nombre ANTES de borrar: despues del delete ya no sirve para el mensaje.
        $nombre = $proyecto->nombre;

        $proyecto->delete();

        return redirect()->route('registro-proyecto.index')
            ->with('status', "Proyecto \"{$nombre}\" eliminado.");
    }
}
