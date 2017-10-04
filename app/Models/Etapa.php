<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etapa extends Model
{
    //
    protected $table = 'etapa';
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    protected $fillable = ['nombre', 'descripcion', 'fecha_inicio', 'fecha_fin'];

    public function team(){
      return $this->belongsToMany('App\Models\Equipo', 'equipo_tiene_etapa', 'etapa_id', 'equipo_id')
              ->withPivot('id', 'puntaje_promedio', 'clasifico');
    }

    public function hasCheckpoints(){
      return $this->hasMany('App\Models\Checkpoint');
    }
}
