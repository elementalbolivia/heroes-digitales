<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoProyecto extends Model
{
    protected $table = 'video_proyecto';
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    protected $fillable = ['proyecto_id', 'nombre_archivo', 'es_pitch', 'es_demo'];

    public function videoProyecto(){
    	return $this->belongsTo('App\Models\Proyecto');
    }
}
