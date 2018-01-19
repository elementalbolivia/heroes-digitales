<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacheableUsuario extends Model
{
    protected $table = 'teacheable_usuario';
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    protected $fillable = ['usuario_id'];

    public function user(){
      return $this->belongsTo('App\Models\Usuario');
    }
}
