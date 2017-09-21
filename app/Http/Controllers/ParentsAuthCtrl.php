<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

date_default_timezone_set('America/La_Paz');

class ParentsAuthCtrl extends Controller
{
    public function accept(Request $request){
    	$user = Usuario::find($request->uid);
    	$user->student->responsable()->create([
    		'estudiante_id'	 => $user->student->id,
    		'firma'			 => $request->signature,
    		'fecha_creacion' => date('Y-m-d H:i:s'),
    	]);
    	return response()->json(['success' => true]);
    }
}
