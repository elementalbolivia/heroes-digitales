<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipoTieneCalificacion extends Model
{
    //
    protected $table = 'equipo_tiene_calificacion';
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    protected $fillable = ['juez_id', 'experto_id',
                       'equipo_id', 'checkpoint_tiene_pregunta_id',
                      'puntaje', 'comentario'];
    
}
