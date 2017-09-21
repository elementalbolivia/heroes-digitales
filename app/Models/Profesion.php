<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profesion extends Model
{
    protected $table = 'profesion';
    public $timestamps = false;

    public static function professionData($id){
    	$prof = self::find($id);
    	return [
    			'id'		=> $prof->id,
    			'nombre'	=> $prof->nombre,
    			];
    }
}
