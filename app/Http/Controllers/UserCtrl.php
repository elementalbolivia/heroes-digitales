<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Traits\EmailTrait;
use App\Models\Equipo;
use App\Models\EstudianteMentorTieneEquipo;

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
					$team  = Equipo::find($request->teamId);
					if($invited != null){
						$type = $request->type == 'student' ? 'estudiante' : 'mentor';
						if($request->type == 'student'){
							$userId = $invited->student->id;
						}else{
							$userId = $invited->mentor->id;
						}
						if($invited->isMemberOfAnyTeam($userId, $request->type)){
							$res->success = false;
							$res->title = 'El '. $type .' ya tiene un equipo';
							$res->msg = 'El ' . $type . ' con correo electrónico '. $invited->correo . ' ya forma parte de un equipo';
							return response()->json($res);
						}
						if($invited->isMemberOfMyTeam($request->teamId, $userId, $request->type)){
							$res->success = false;
							$res->title = 'Ya enviaste una invitación al ' . $type;
							$res->msg = 'El ' . $type . ' con correo electrónico '. $invited->correo . ', ya recibió una invitación de tu equipo';
							return response()->json($res);
						}
						// Enviar invitación a usuario que tiene un cuenta
						$isStudent = $request->type == 'student' ? true : false;
						$invitation = $invited->getInvitation($isStudent, $userId, $request->teamId);
						$acceptUrl = config('constants.API.LOCAL_URL') . 'confirm-invitation/' . $invitation->id . '/' . $invitation->token .'/team/' .$team->id. '/ACCEPT';
						$refuseUrl = config('constants.API.LOCAL_URL') . 'confirm-invitation/' . $invitation->id . '/' . $invitation->token .'/team/'. $team->id .'/REFUSE';
						EmailTrait::sendInvitationEmail($team->nombre_equipo, $acceptUrl, $refuseUrl);
						$res->success = true;
						$res->title = 'Invitación enviada';
						$res->msg = 'El ' . $type . ' ' . $invited->correo . ' ya tiene una cuenta en la plataforma. Se le envió una notificación por email para pueda aceptar la invitación a unirse a tu equipo.';
						$res->team_id = $request->teamId;
						$res->role = $request->type == 'student' ? 1 : 2 ;
						$res->uid = $invited->id;
						$res->action = 'EXIST';
						return response()->json($res);
					}else{
						// Enviar invitacion mediante mail
						$leader = Usuario::find($request->leaderId);
						$registerUrl = config('constants.STATE.LOCAL_URL') . 'registro/' . $request->type . '/invitacion/' . $request->teamId;
						EmailTrait::invitationEmail($request->mail, $leader->nombres . ' ' . $leader->apellidos, $team->nombre_equipo, $registerUrl);
						$res->action = 'SEND_EMAIL';
						$res->success = true;
						$res->title = 'Invitación enviada!';
						$res->msg = 'Una invitación fue enviada a ' . $request->mail . ' con instrucciones para completar su proceso de registro. Una vez registrado será parte de tu equipo automáticamente';
						return response()->json($res);
					}
			}catch(\Exception $e){
				$res->success = false;
				$res->msg = 'Hubo un error al enviar la invitación, inténtelo nuevamente: ' . $e->getMessage();
				return response()->json($res);
			}
		}
}
