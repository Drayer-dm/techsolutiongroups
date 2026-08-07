<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    /**
     * Tabla asociada al modelo.
     */
    protected $table = 'usuarios';

    /**
     * Columnas que se pueden llenar en masa.
     * 'created_by' de Proyecto queda fuera a propósito: lo pone el servidor.
     */
    protected $fillable = ['nombre', 'correo', 'clave'];

    /**
     * Columnas ocultas al convertir el modelo a array o JSON.
     */
    protected $hidden = ['clave'];

    /**
     * Conversiones automáticas de tipo.
     */
    protected $casts = [
        'clave' => 'hashed',
    ];

    /**
     * Nombre de la columna que guarda el hash de la clave.
     * Laravel asume 'password'; aquí la columna se llama 'clave'.
     */
    public function getAuthPasswordName(): string
    {
        return 'clave';
    }

    /**
     * Proyectos que este usuario creó.
     */
    public function proyectos(): HasMany
    {
        return $this->hasMany(Proyecto::class, 'created_by');
    }
}
