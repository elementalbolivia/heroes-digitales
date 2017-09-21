<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Responsable extends Model
{
    protected $table = 'responsable';
    public $timestamps = false;
    protected $fillable = ['estudiante_id', 'firma', 'fecha_creacion'];

    public function estudiante(){
    	return $this->belongsTo('App\Models\Estudiante');
    }
}
