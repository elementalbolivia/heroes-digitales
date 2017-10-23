<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Traits\EmailTrait;
use App\Models\Responsable;

date_default_timezone_set('America/La_Paz');

class ParentsAuthCtrl extends Controller
{
    public function accept(Request $request){
    	try{
        $user = Usuario::find($request->uid);
      	$auth = $user->student->responsable()->create([
      		'estudiante_id'	 => $user->student->id,
      		'firma'			 => $request->signature,
          'correo_electronico'  => $request->email,
      		'fecha_creacion' => date('Y-m-d H:i:s'),
          'token'        => md5(date('YmdHis')) . md5($request->uid),
      	]);
        EmailTrait::parentsEmail($user->id, $auth->correo_electronico, $auth->id, $auth->token);
      	return response()->json(['msg' => 'Se le envío un correo electrónico a tu padre/apoderado para que pueda autorizar tu participación', 'success' => true]);
      }catch(\Exception $e){
        return response()->json(['msg' => 'Hubo un error al enviar el correo electrónico a tu padre/apoderado, inténtalo nuevamente ' . $e->getMessage(), 'success' => false]);
      }
    }
    public function parentSign(Request $request){
      $res = (object) null;
      try{
        $responsable = Responsable::find($request->rid);
        $responsable->activo = true;
        $res->success = true;
        $res->msg = 'Su hijo ya está autorizado para concursar en Héroes Digitales, puede visitar la página de inicio para tener más información al respecto';
        return response()->json($res);
      }catch(\Exception $e){
        $res->success = true;
        return response()->json($res);
      }

    }
}
