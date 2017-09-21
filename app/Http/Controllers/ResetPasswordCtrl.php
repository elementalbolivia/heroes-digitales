<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

use Hash;
// Traits
use App\Traits\EmailTrait;

date_default_timezone_set('America/La_Paz');
class ResetPasswordCtrl extends Controller
{
	use EmailTrait;
    public function sendVerifEmail(Request $request){
    	$res = (object) null;
    	try{
            $user = Usuario::where('correo', $request->email)->first();
    		if($user == NULL OR $user->activo != 1){
    			$res->success = false;
    			$res->msg = 'El correo electrónico no existe, intente con uno válido';
    		}else{
		    	EmailTrait::authEmail($request->email);
		    	$res->success = true;
		    	$res->msg = 'Por favor ingrese a su correo electrónico, para reestablecer su contraseña';
    		}
            return response()->json($res);
    	}catch(Exception $e){
    		$res->success = false;
    		$res->msg = 'Hubo un error al enviar el correo electrónico, inténtelo nuevamente';
            return response()->json($res);
        }
    }
    public function reset(Request $request){
        $user = Usuario::find($request->uid);
        $res = (object) null; 
        $now = date('Y-m-d H:i:s');
        if($user){
            if($user->resetPassword->token == $request->token){
                if($now >= $user->resetPassword->fecha_inicio AND $now <= $user->resetPassword->fecha_fin ){
                    $user->password = Hash::make($request->password);
                    $user->save();
                    $res->success = true;
                }else{
                    $res->success = false;
                    $res->msg = 'Credenciales expirados, por favor solicite un nuevo cambio de contraseña';
                }
            }else{
                $res->success = false;
                $res->msg = 'Su token no es correcto';
            }
        }else{
            $res->success = false;
            $res->msg = 'El usuario no existe';
        }
        return response()->json($res);
    } 
}
