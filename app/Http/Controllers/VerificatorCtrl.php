<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Traits\JwtTraitAuth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTFactory;
use Hash;
/**
 * CODES CONFIG:
 * 		-
 */

class VerificatorCtrl extends Controller
{
	use JwtTraitAuth;
	/**
	 * [confirmRegisterEmail description]
	 * @param  [type] $userId [description]
	 * @param  [type] $token  [description]
	 * @return [type]         [description]
	 */
    public function redirect($id, $token, $mail){
        if($id == NULL || $token == NULL || $mail == NULL)
            return response()->redirectTo(config('constants.STATE.LOCAL_URL').'error-confirmacion');
        return response()->redirectTo(config('constants.STATE.LOCAL_URL').'confirmacion-usuario/'. $id . '/' . $token . '/' . $mail);
    }
    public function confirmRegisterEmail(Request $request){
    	if($request->uid == NULL || $request->token == NULL){
    		return response()->json([
    			'success'	=> false,
    			'msg'		=> 'Sus datos son incorrectos',
    		]);
    	}
    	$user = Usuario::find($request->uid);
    	if($user != NULL){
            if($user->activo)
                return response()->json(['success'  => true, 'already_verif' => true, 'path'    => 'home']);
						if(Hash::check($request->password, $user->password))
							return response()->json(['success'  => false, 'msg' => 'La contraseña no es correcta']);

    		if($user->emailConfirmation->token == $request->token){
                $credentials = [
                    'correo'    => $request->email,
                    'password'  => $request->password,
                ];
                try {
                    // attempt to verify the credentials and create a token for the user
                    if (! $token = JWTAuth::attempt($credentials)) {
                        return response()->json(['error' => 'invalid_credentials'], 401);
                    }
                } catch (JWTException $e) {
                    // something went wrong whilst attempting to encode the token
                    return response()->json(['error' => 'could_not_create_token'], 500);
                }
                $user->activo = true;
                $user->save();
                $role = $user->role($user->id);
                $res = [
                        'success'   => true,
                        'uid'       => $user->id,
                        'rid'       => $role->rol_id,
                        'path'      => '',
                        'username'  => $user->nombres,
                        'token'     => $token
                    ];
                // $token= $userId;
                // Enviar a ruta que procese los datos de autenticacion
                // del usuario, y luego lo envie al dashboard
    			if($role->rol_id == 1 || $role->rol_id == 2){
                    $res['path'] = 'user';
                }else if($role->rol_id == 3 || $role->rol_id == 4){
                    $res['path'] = 'expert';
                }else{
                    $res['path'] = 'admin';
                }
                return response()->json($res);
    		}else{
    			return response()->json([
	    			'success'	=> false,
	    			'msg'		=> 'Su código de autentificación no es correcto.',
	    		]);
    		}
    	}else{
            return response()->json([
                'success'   => false,
                'msg'       => 'El usuario no existe.',
            ]);
        }
    }
}
