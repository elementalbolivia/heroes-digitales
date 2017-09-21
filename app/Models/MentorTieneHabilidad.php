<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MentorTieneHabilidad extends Model
{
    protected $table = 'mentor_tiene_habilidad';
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    protected $fillable = ['experticia_id', 'habilidad_id', 'mentor_id'];
}
