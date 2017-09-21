<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImagenProyecto extends Model
{
    protected $table = 'imagen';
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    protected $fillable = ['nombre_archivo', 'es_banner', 'es_screen'];

    public function proyecto(){
    	return $this->belongsTo('App\Models\Proyecto');
    }
}
