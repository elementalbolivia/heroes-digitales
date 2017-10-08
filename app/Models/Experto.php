<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TamanoPolera;
class Experto extends Model
{
    protected $table = 'experto';
    public $timestamps = false;
    protected $fillable = ['tamano_polera_id'];
    
    public function usuario(){
    	return $this->belongsTo('App\Models\Usuario');
    }
    public function shirtSize($shirtId){
      return TamanoPolera::find($shirtId);
    }
}
