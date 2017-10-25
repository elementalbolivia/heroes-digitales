<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    protected $table = 'mentor';
    public $timestamps = false;

    public function user(){
    	return $this->belongsTo('App\Models\Usuario', 'usuario_id');
    }
    public function skills(){
    	return $this->belongsToMany('App\Models\Habilidad', 'mentor_tiene_habilidad', 'mentor_id', 'habilidad_id')
    			->withPivot('id', 'experticia_id', 'fecha_creacion', 'fecha_actualizacion');
    }
    public function requests(){
        return $this->hasMany('App\Models\EstudianteMentorTieneEquipo', 'mentor_id');
    }
    public function team(){
    	return $this->belongsTo('App\Models\Equipo', 'estudiante_mentor_tiene_equipo', 'mentor_id', 'equipo_id')
    			->withPivot('lider_equipo', 'aprobado', 'fecha_creacion', 'fecha_actualizacion');
    }
    public function member(){
        return $this->hasOne('App\Models\EstudianteMentorTieneEquipo', 'mentor_id');
    }
    public function invitationsToTeam(){
        return $this->belongsToMany('App\Models\Equipo', 'invitaciones_equipo', 'mentor_id', 'equipo_id')
                ->withPivot('id', 'activo', 'confirmacion', 'fecha_creacion', 'fecha_actualizacion');
    }
}
