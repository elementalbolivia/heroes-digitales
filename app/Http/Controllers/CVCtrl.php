<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class CVCtrl extends Controller
{
    public function getCV($name){
    	return response()->json(['path' => storage_path().'/app/public/curriculums/' . $name]);
    }
}
