<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvitacionesEquipo extends Model
{
    protected $table = 'invitaciones_equipo';
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    protected $fillable = ['mentor_id', 'estudiante_id', 'equipo_id', 'token'];
}
