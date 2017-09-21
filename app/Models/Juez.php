<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Juez extends Model
{
    protected $table = 'juez';
    public $timestamps = false;

    public function usuario(){
    	return $this->belongsTo('App\Models\Usuario');
    }
}
