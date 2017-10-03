<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TipoPregunta;

class Pregunta extends Model
{
    //
    protected $table = 'pregunta';
    constant CREATED_AT = 'fecha_creacion';
    constant UPDATED_AT = 'fecha_actualizacion';
    protected $fillable = ['tipo_pregunta_id', 'pregunta'];

    public function typeQuestion($type_id){
      return TipoPregunta::find($type_id)->nombre;
    }
}
