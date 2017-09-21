<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experticia extends Model
{
    protected $table = 'experticia';
    public $timestamps = false;
    public static function skillLevel($id){
    	$skill = self::find($id);
    	return [
    		'id'		=> $skill->id,
    		'nombre'	=> $skill->nombre,
    	];
    }
}
