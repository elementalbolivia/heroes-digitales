<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Colegio;

class Estudiante extends Model
{
    protected $table = 'estudiante';
    public $timestamps = false;
    protected $fillable = ['usuario_id', 'colegio'];

    public function user(){
    	return $this->belongsTo('App\Models\Usuario');
    }
    public function responsable(){
    	return $this->hasOne('App\Models\Responsable');
    }
    public function team(){
    	return $this->belongsToMany('App\Models\Equipo', 'estudiante_mentor_tiene_equipo', 'estudiante_id', 'equipo_id')
    			->withPivot('id', 'lider_equipo', 'aprobado', 'fecha_creacion', 'fecha_actualizacion');
    }
    public function member(){
        return $this->hasOne('App\Models\EstudianteMentorTieneEquipo', 'estudiante_id');
    }
    public function requests(){
        return $this->hasMany('App\Models\EstudianteMentorTieneEquipo', 'estudiante_id');
    }
    public function invitationsToTeam(){
        return $this->belongsToMany('App\Models\Equipo', 'invitaciones_equipo', 'estudiante_id', 'equipo_id')
                ->withPivot('id', 'activo', 'confirmacion', 'fecha_creacion', 'fecha_actualizacion');
    }

}
