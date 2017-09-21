<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';
    public $timestamps = false;

    public function usuario(){
    	return $this->belongsTo('App\Models\Usuario');
    }

}
