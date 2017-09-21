<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReestablecerPassword extends Model
{
    protected $table = 'reestablecer_password';
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    protected $fillable = ['usuario_id', 'token', 'fecha_inicio', 'fecha_fin'];
    
    public function user(){
    	return $this->belongsTo('App\Models\Usuario');
    }
}
