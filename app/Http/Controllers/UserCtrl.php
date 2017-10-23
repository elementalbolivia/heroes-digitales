<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Traits\EmailTrait;
use App\Models\Equipo;

use App\Traits\UserTrait as UserTrait;
use Storage;

class UserCtrl extends Controller
{
	use UserTrait;
	use EmailTrait;
    public function updateImg(Request $request, $id){
    	$res = (object) null;
			try{
				UserTrait::updateImg(new Storage(), $request, $id);
				$res->success = true;
			}catch(\Exception $e){
				$res->success = false;
				$res->msg = 'Hubo un error al actualizar su imagen, inténtelo nuevamente:' . $e->getMessage();
			}finally{
				return response()->json($res);
			}
    }
		public function sendEmailInvitation(Request $request){
			$invited = Usuario::where('correo', $request->mail)->first();
			$res = (object) null;
			try{
					if($invited != null){
					// Enviar invitación a usuario que tiene un cuenta
					$res->success = true;
					$res->team_id = $request->teamId;
					$res->role = $request->type == 'student' ? 1 : 2 ;
					$res->uid = $invited->id;
					$res->action = 'EXIST';
					return response()->json($res);
				}else{
					// Enviar invitacion mediante mail
					$leader = Usuario::find($request->leaderId);
					$team  = Equipo::find($request->teamId);
					$registerUrl = config('constants.STATE.LOCAL_URL') . 'registro/' . $request->type . '/invitacion/' . $request->teamId;
					EmailTrait::invitationEmail($request->mail, $leader->nombres, $team->nombre_equipo, $registerUrl);
					$res->action = 'SEND_EMAIL';
					$res->success = true;
					$res->msg = 'Su correo electrónico su enviado con éxito';
					return response()->json($res);
				}
			}catch(\Exception $e){
				$res->success = false;
				$res->msg = 'Hubo un error al enviar la invitación, inténtelo nuevamente';
				return response()->json($res);
			}
		}
}
