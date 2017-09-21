<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class HonorCodeCtrl extends Controller
{
    public function accept(Request $request){
    	$user = Usuario::find($request->uid);
    	$user->terminos_uso = true;
    	$user->save();
    	return response()->json(['success' => true]);
    }
}
