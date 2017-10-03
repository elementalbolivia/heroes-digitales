<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoPregunta extends Model
{
    protected $table = 'tipo_pregunta';
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    protected $fillable = ['nombre'];

    public function question(){
      return $this->belongsTo('App\Models\Pregunta');
    }
}
