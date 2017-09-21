<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Biografia extends Model
{
    protected $table = 'biografia';
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    protected $fillable = ['usuario_id', 'descripcion'];

    public function usuario(){
    	return $this->belongsTo('App\Models\Usuario');
    }
}
