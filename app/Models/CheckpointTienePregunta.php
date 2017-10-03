<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckpointTienePregunta extends Model
{
    //
    protected $table = 'checkpoint_tiene_pregunta';
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    protected $fillable = ['checkpoint_id', 'pregunta_id'];

}
