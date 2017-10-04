<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checkpoint extends Model
{
    protected $table = 'checkpoint';
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    protected $fillable = ['etapa_id', 'nombre', 'fecha_evaluacion'];

    public function hasQuestions(){
      return $this->belongsToMany('App\Models\Pregunta', 'checkpoint_tiene_pregunta', 'checkpoint_id', 'pregunta_id')
        ->withPivot('id', 'fecha_creacion', 'fecha_actualizacion');
    }

    public function stage(){
      return $this->belogsTo('App\Models\Etapa');
    }

}
