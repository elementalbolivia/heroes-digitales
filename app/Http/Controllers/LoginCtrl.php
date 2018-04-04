<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWT\Exception;
use DB;
use Carbon\Carbon;

date_default_timezone_set('America/La_Paz');

class LoginCtrl extends Controller
{
    public function login(Request $request){
    	if($request->email == NULL || $request->password == NULL){
    		return response()->json([
    			'success'	=> false,
    			'msg'		=> 'Sus datos son incorrectos',
    		]);
    	}
    	$user = Usuario::where('correo', $request->email)->first();
    	if($user != null){
    		if(!$user->activo){
    			return response()->json([
	    			'success'	=> false,
	    			'msg'		=> 'Debe verificar su cuenta, ingrese a su correo electrónico',
	    		]);
    		}
    		$credentials = [
	    		'correo'	=> $request->email,
	    		'password'	=> $request->password,
	    	];
        $expiration = ['exp' => Carbon::now()->addweek()->timestamp];
	    	try {
	            // attempt to verify the credentials and create a token for the user
	            if (! $token = JWTAuth::attempt($credentials, $expiration)) {
	                return response()->json(['success' => false, 'msg' => 'Sus datos son incorrectos', 'error' => 'invalid_credentials']);
	            }
	        } catch (JWTException $e) {
	            // something went wrong whilst attempting to encode the token
	            return response()->json(['success' => false, 'msg' => 'Hubo un error al crear sus credenciales, inténtelo nuevamente', 'error' => 'could_not_create_token']);
	        }
          $role = $user->role($user->id)->rol_id;
          // $token= $userId;
          // Enviar a ruta que procese los datos de autenticacion
          // del usuario, y luego lo envie al dashboard
    			$res = $this->getCredsPerUser($user, $token, $role);
          if( ($role == 1 || $role == 2) && (!$res['has_team'] || $res['has_team'] == NULL) )
            return response()->json(['success' => false, 'msg' => 'Lo sentimos, no puedes acceder debido a que no lograste completar tu equipo a tiempo, te esperamos en una siguiente versión', 'error' => 'contest_timeout']);
          return response()->json($res);
    	}else{
    		return response()->json([
    			'success'	=> false,
    			'msg'		=> 'El usuario no existe, por favor regístrese',
    		]);
    	}
        // all good so return the token
   	}
    /**
     * [getCredsPerUser description]
     * @param  [type] $res    [description]
     * @param  [type] $user   [description]
     * @param  [type] $roleId [description]
     * @return [type]         [description]
     */
    public function getCredsPerUser($user, $token, $roleId){
        $temp = [
                'success'   => true,
                'uid'       => $user->id,
                'rid'       => $roleId,
                'path'      => '',
                'username'  => $user->nombres,
                'token'     => $token
            ];
        $temp['min_fields'] = ($user->image != NULL)
                                && ($user->biography != NULL)
                                && ($user->terminos_uso != NULL) ? true : false;
        if($roleId == 1)
          $temp['min_fields'] = $temp['min_fields'] && ($user->student->responsable != NULL);
        if($roleId == 1 || $roleId == 2){
            // Mentor o estudiante
            $id = $roleId == 1 ? $user->student->id : $user->mentor->id;
            $field = $roleId == 1 ? 'estudiante_id' : 'mentor_id';
            $team = DB::table('equipo')
                      ->join('estudiante_mentor_tiene_equipo', 'equipo.id', '=', 'estudiante_mentor_tiene_equipo.equipo_id')
                      ->where([['estudiante_mentor_tiene_equipo' . '.'. $field, '=', $id],
                               ['equipo.activo', '=', 1],
                               ['estudiante_mentor_tiene_equipo.aprobado', '=', 1],
                               ['estudiante_mentor_tiene_equipo.activo', '=', 1]])
                      ->first();
            if($team != NULL){
                $temp['team_id'] = $team != NULL ? $team->equipo_id : false;
                $temp['has_team'] = $team != NULL ? true : false;
                $temp['is_leader'] = ($team->lider_equipo == 1) ? true : false;
            }else{
                $temp['has_team'] = NULL;
                $temp['team_id'] = NULL;
                $temp['is_leader'] = NULL;
            }
            $temp['path'] = 'user';
        }else if($roleId == 4){
            
            $temp['path'] = 'expert';
        }else if($roleId == 5){
            $temp['path'] = 'admin';
        }else if($roleId == 6){
            $temp['path'] = 'admin';
        }
        return $temp;
    }
}
