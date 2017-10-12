<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatosProfesionales extends Model
{
    protected $table = 'datos_profesionales';
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    protected $fillable = ['usuario_id', 'profesion', 'organizacion', 'trabajo', 'cv', 'red_social_url'];

    public function usuario(){
    	return $this->belongsTo('App\Models\Usuario');
    }
}
