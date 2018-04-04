<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpertoEvaluaEquipo extends Model
{
    protected $table = 'experto_evalua_equipo';
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    protected $fillable = ['experto_id', 'equipo_id'];
    
}
