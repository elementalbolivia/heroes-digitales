<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Categoria;
use DB;

class Proyecto extends Model
{
    protected $table = 'proyecto';
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    protected $fillable = ['equipo_id'];
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
    public function getPitch(){
      $pitchQ = DB::table('proyecto')
                ->join('video_proyecto', 'proyecto.id', '=', 'video_proyecto.proyecto_id')
                ->select('video_proyecto.id', 'video_proyecto.youtube_url')
                ->where('video_proyecto.proyecto_id', '=', $this->id)
                ->where('video_proyecto.es_equipo', '=', 1)
                ->get();
      $pitch = count($pitchQ) > 0 ? $pitchQ[count($pitchQ) - 1] : NULL;
      return $pitch == NULL ? ['id' => null, 'youtube_url' => '', 'is_demo' => false, 'is_team' => true] :
                              ['id' => $pitch->id, 'youtube_url' => $pitch->youtube_url, 'is_demo' => false, 'is_team' => true];
    }
    public function getDemo(){
      $demoQ = DB::table('proyecto')
                ->join('video_proyecto', 'proyecto.id', '=', 'video_proyecto.proyecto_id')
                ->select('video_proyecto.id', 'video_proyecto.youtube_url')
                ->where('video_proyecto.proyecto_id', '=', $this->id)
                ->where('video_proyecto.es_demo', '=', 1)
                ->get();
      $demo = count($demoQ) > 0 ? $demoQ[count($demoQ) - 1] : NULL;
      return $demo == NULL ? ['id' => null, 'youtube_url' => '', 'is_demo' => true, 'is_team' => false] :
                      ['id' => $demo->id, 'youtube_url' => $demo->youtube_url, 'is_demo' => true, 'is_team' => false];
    }
}
