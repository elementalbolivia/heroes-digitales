<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TamanoPolera;

class Juez extends Model
{
    protected $table = 'juez';
    public $timestamps = false;
    protected = ['tamano_polera_id'];

    public function usuario(){
    	return $this->belongsTo('App\Models\Usuario');
    }
    public function shirtSize($shirtId){
      return TamanoPolera::find($shirtId);
    }
}
