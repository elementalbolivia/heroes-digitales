<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Categoria;

class Proyecto extends Model
{
    protected $table = 'proyecto';
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    protected $fillable = ['equipo_id', 'categoria_id', 'nombre_proyecto', 'descripcion'];
    public function team(){
      return $this->belongsTo('App\Models\Equipo');
    }
    public function videoProyecto(){
      return $this->hasMany('App\Models\VideoProyecto');
    }
    public function imagenProyecto(){
      return $this->hasMany('App\Models\ImagenProyecto');
    }
      public function category($id){
          return Categoria::find($id);
      }
}
