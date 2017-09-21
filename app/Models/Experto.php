<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experto extends Model
{
    protected $table = 'experto';
    public $timestamps = false;

    public function usuario(){
    	return $this->belongsTo('App\Models\Usuario');
    }
}
