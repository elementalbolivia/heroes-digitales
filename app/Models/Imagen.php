<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    protected $table = 'imagen';
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    protected $fillable = ['usuario_id', 'nombre_archivo'];
	
	public function usuario(){
    	return $this->belongsTo('App\Models\Usuario');
    }
}
