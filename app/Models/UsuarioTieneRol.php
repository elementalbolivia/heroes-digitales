<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioTieneRol extends Model
{
    protected $table = 'usuario_tiene_rol';
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    protected $fillable = ['usuario_id', 'rol_id'];

    public function usuario(){
    	return $this->belongsTo('App\Models\Usuario');
    }
    public function rol(){
    	return $this->belongsTo('App\Models\Rol');
    }
}
