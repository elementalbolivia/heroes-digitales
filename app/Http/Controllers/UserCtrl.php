<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Traits\EmailTrait;
use App\Models\Equipo;
use App\Models\EstudianteMentorTieneEquipo;
use App\Models\InvitacionesEquipo;

use App\Traits\UserTrait as UserTrait;
use Storage;
use Hash;

class UserCtrl extends Controller
{
	use UserTrait;
	use EmailTrait;
    public function updateImg(Request $request, $id){
    	$res = (object) null;
			try{
				UserTrait::updateUserImg(new Storage(), $request, $id);
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
							if($invited->student == null){
									$res->success = false;
									$res->title = 'Error';
									$res->msg = 'El participante con correo electrónico '. $invited->correo . ' es un mentor';
									return response()->json($res);
							}
							$userId = $invited->student->id;
							$isStudent = true;
						}else{
							if($invited->mentor == null){
									$res->success = false;
									$res->title = 'Error';
									$res->msg = 'El participante con correo electrónico '. $invited->correo . ' es un estudiante';
									return response()->json($res);
							}
							$userId = $invited->mentor->id;
							$isStudent = false;
						}

						if($invited->isMemberOfAnyTeam($userId, $request->type)){
							$res->success = false;
							$res->title = 'El '. $type .' ya tiene un equipo';
							$res->msg = 'El ' . $type . ' con correo electrónico '. $invited->correo . ' ya forma parte de un equipo';
							return response()->json($res);
						}
						if($invited->isMemberOfMyTeam($request->teamId, $userId, $request->type)){
							$res->success = false;
							$res->title = 'El' . $type . ' ya es parte de tu equipo';
							$res->msg = 'El ' . $type . ' con correo electrónico '. $invited->correo . ', ya es parte de tu equipo';
							return response()->json($res);
						}
						if($invited->isInvitationSend($request->teamId, $userId, $request->type)){
							$res->success = false;
							$res->title = 'Ya enviaste una invitación a ' . $invited->correo;
							$res->msg = 'El ' . $type . ' con correo electrónico '. $invited->correo . ', ya recibió una invitación de tu equipo';
							return response()->json($res);
						}
						// Enviar invitación a usuario que tiene un cuenta
						$newInvitation = [
                'equipo_id'     => $request->teamId,
                'mentor_id'     => NULL,
                'estudiante_id' => NULL,
								'token'					=> md5(date('YmdHis')) . md5($request->teamId),
            ];
            if($request->type == 'student')
                $newInvitation['estudiante_id'] = $userId;
            else
                $newInvitation['mentor_id'] = $userId;

            $invitation = InvitacionesEquipo::create($newInvitation);
						$acceptUrl = config('constants.API.LOCAL_URL') . 'confirm-invitation/' . $invitation->id . '/' . $invitation->token .'/team/' .$team->id. '/ACCEPT';
						$refuseUrl = config('constants.API.LOCAL_URL') . 'confirm-invitation/' . $invitation->id . '/' . $invitation->token .'/team/'. $team->id .'/REFUSE';
						// EmailTrait::sendInvitationEmail($request->mail, $team->nombre_equipo, $acceptUrl, $refuseUrl);
						$res->success = true;
						$res->title = 'Invitación enviada';
						$res->msg = 'El ' . $type . ' ' . $invited->correo . ' ya tiene una cuenta en la plataforma. Se le envió una notificación por email para pueda aceptar la invitación a unirse a tu equipo.';
						$res->team_id = $request->teamId;
						$res->role = $request->type == 'student' ? 1 : 2 ;
						$res->uid = $invited->id;
						return response()->json($res);
					}else{
						// Enviar invitacion mediante mail
						$leader = Usuario::find($request->leaderId);
						$registerUrl = config('constants.STATE.LOCAL_URL') . 'registro/' . $request->type . '/invitacion/' . $request->teamId;
						// EmailTrait::invitationEmail($request->mail, $leader->nombres . ' ' . $leader->apellidos, $team->nombre_equipo, $registerUrl);
						$res->action = 'SEND_EMAIL';
						$res->success = true;
						$res->title = 'Invitación enviada!';
						$res->msg = 'Una invitación fue enviada a ' . $request->mail . ' con instrucciones para completar su proceso de registro. Una vez registrado será parte de tu equipo automáticamente';
						return response()->json($res);
					}
			}catch(\Exception $e){
				$res->success = false;
				$res->err =  $e->getMessage();
				$res->msg = 'Hubo un error al enviar la invitación, inténtelo nuevamente';
				return response()->json($res);
			}
		}
		public function updatePassword(Request $request, $uid){
			$res = (object) null;
			try{
				$user = Usuario::find($uid);
				if(Hash::check($request->newPassword, $user->password)){
					$res->success = false;
					$res->msg = 'Debe escoger una contraseña distinta a la anterior';
				}else{
					$newPass = Hash::make($request->newPassword);
					$user->password = $newPass;
					$user->save();
					$res->success = true;
					$res->msg = 'Su contraseña fue actualizada con éxito';
				}
			}catch(\Exception $e){
				$res->success = false;
				$res->msg = 'Hubo un error al actualizar su contraseña';
			}finally{
				return response()->json($res);
			}
		}
		public function setActive(Request $request){
			$res = (object) null;
			try{
				$user = Usuario::find($request->uid);
				$user->activo = $request->action;
				$user->save();
				$res->success = true;
				$res->msg = 'El usuario fue actualizado con éxito';
				return response()->json($res);
			}catch(Exception $e){
				$res->success = false;
				$res->err = $e->getMessage();
				$res->msg = 'Hubo un error al actualizar al usuario, inténtelo nuevamente';
				return response()->json($res);
			}
		}
}
