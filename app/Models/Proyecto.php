<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Proyecto extends Model
{
    /**
     * Tabla asociada al modelo.
     */
    protected $table = 'proyectos';

    /**
     * Columnas que se pueden llenar en masa.
     * 'created_by' queda fuera: lo asigna el servidor, no el formulario.
     */
    protected $fillable = ['nombre', 'fecha_inicio', 'estado', 'responsable', 'monto'];

    /**
     * Conversiones automáticas de tipo.
     */
    protected $casts = [
        'fecha_inicio' => 'date',
    ];

    /**
     * Usuario que creó el proyecto.
     */
    public function creador(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'created_by');
    }
}
