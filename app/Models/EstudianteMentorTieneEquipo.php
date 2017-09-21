<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstudianteMentorTieneEquipo extends Model
{
    protected $table = 'estudiante_mentor_tiene_equipo';
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    protected $fillable = ['equipo_id', 'mentor_id', 'estudiante_id', 'lider_equipo', 'aprobado'];

    public function student(){
    	return $this->belongsTo('App\Models\Estudiante');
    }
    public function mentor(){
    	return $this->belongsTo('App\Models\Mentor');
    }
    public function team(){
    	return $this->belongsTo('App\Models\Equipo');
    }
}
