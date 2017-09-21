<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Usuario;
use App\Models\ConfirmacionEmail;
use App\Mail\Registration;

date_default_timezone_set('America/La_Paz');
class RequestCtrl extends Controller
{
    public function accept(Request $request){
    	$res = (object) null;
    	$user = Usuario::find($request->id);
    	if($request->accept){
    		// Crear un token de seguridad para verificar el mail 
	    	$mailToken = md5($user->correo) . md5(date('YmdHis'));
	    	// Crear una URL para verificar al usuario
	    	$verifUrl = config('Constants.API.LOCAL_URL') . 'email-verification/'. $user->id . '/' . $mailToken . '/' . $user->correo;
	    	// Crear array-assoc para crear token de confirmacion
	    	$verifToken = ConfirmacionEmail::create([
	    		'usuario_id'		=> $user->id,
	    		'token'				=> $mailToken,
	    		'fecha_creacion'	=> date('Y-m-d H:i:s'),
	    	]);

	    	Mail::to($user->correo)
    			->send(new Registration($user->names, $user->lastnames, $verifUrl, 'JUDGE_EXPERT'));
    	}
    	$res->success = true;
    	return response()->json($res);
    }
}
