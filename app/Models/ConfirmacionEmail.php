<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfirmacionEmail extends Model
{
    protected $table = 'confirmacion_email';
    public $timestamps = false;
    protected $fillable = ['usuario_id', 'token', 'fecha_creacion'];

    public function usuario(){
    	return $this->belongsTo('App\Models\Usuario');
    }
}
