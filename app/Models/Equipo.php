<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Division;
use App\Models\Ciudad;

class Equipo extends Model
{
    protected $table = 'equipo';
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    protected $fillable = ['ciudad_id', 'division_id', 'nombre_equipo', 'imagen'];

    public function members(){
    	return $this->hasMany('App\Models\EstudianteMentorTieneEquipo', 'equipo_id');
    }
    public function project(){
    	return $this->hasOne('App\Models\Proyecto', 'equipo_id');
    }
    public function division($id){
        return Division::find($id);
    }
    public function city($id){
        return Ciudad::find($id);
    }
    public function invitations(){
        return $this->belongsToMany('App\Models\Equipo', 'invitaciones_equipo', 'estudiante_id', 'equipo_id')
                ->withPivot('id', 'confirmacion', 'fecha_creacion', 'fecha_actualizacion');
    }
    public function hasStages(){
      return $this->belongsToMany('App\Models\Etapa', 'equipo_tiene_etapa', 'equipo_id', 'etapa_id')
        ->withPivot('id', 'puntaje_promedio', 'clasifico');
    }

}
