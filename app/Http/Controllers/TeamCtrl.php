<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipo;
use App\Models\EstudianteMentorTieneEquipo;
use App\Models\InvitacionesEquipo;
use App\Models\Usuario;
use App\Models\Mentor;
use App\Models\Estudiante;
use App\Traits\UserTrait;
use App\Traits\TeamTrait;
use DB;
use Storage;

class TeamCtrl extends Controller
{
		use TeamTrait;
		use UserTrait;
    public function index(){
    	$teams = [];
    	$res = (object) null;
    	try{
	    	foreach (Equipo::where('activo', '=', 1)->get() as $team) {
	    		$teams[] = TeamTrait::teamInfo($team->id);
	       	}
	       	$res->success = true;
	       	$res->teams = $teams;
    		return response()->json($res);
    	}catch(\Exception $e){
    		$res->success = false;
    		$res->msg = 'Hubo un error al cargar los equipos, inténtelo nuevamente';
    		return response()->json($res);
    	}
    }
		public function indexAdmin(){
    	$teams = [];
    	$res = (object) null;
    	try{
	    	foreach (Equipo::where('activo', '=', 1)->get() as $team) {
	    		$teams[] = TeamTrait::teamInfoAdmin($team->id);
	       	}
	       	$res->success = true;
	       	$res->teams = $teams;
    		return response()->json($res);
    	}catch(\Exception $e){
				$res->err = $e->getMessage();
    		$res->success = false;
    		$res->msg = 'Hubo un error al cargar los equipos, inténtelo nuevamente';
    		return response()->json($res);
    	}
    }
    public function getTeam($id){
    	$res = (object) null;
    	try{
	       	$res->success = true;
	       	$res->team = TeamTrait::teamInfo($id);
    		return response()->json($res);
    	}catch(\Exception $e){
    		$res->success = false;
    		$res->msg = 'Hubo un error al cargar los equipos, inténtelo nuevamente';
    		return response()->json($res);
    	}
    }
    public function editTeam(Request $request){
        $team = Equipo::find($request->id);
        $res = (object) null;
        try{
            $teamData = (object) $request->only(['team_name', 'project_name', 'project_desc', 'cityId', 'divisionId', 'categoryId']);
            // Actualizar equipo
            $team->nombre_equipo = $teamData->team_name;
            $team->ciudad_id     = $teamData->cityId;
            $team->division_id   = $teamData->divisionId;
            $team->save();
            // Actualizar proyecto
            $project = $team->project;
            $project->nombre_proyecto = $teamData->project_name;
            $project->descripcion = $teamData->project_desc;
            $project->categoria_id = $teamData->categoryId;
            $project->save();
            $res->success = true;
            $res->msg = 'Los datos se actualizaron con éxito';
            return response()->json($res);
        }catch(\Exception $e){
            $res->success = false;
            $res->success = 'Hubo un error al actualizar los datos del equipo';
            return response()->json($res);
        }
    }
    public function editTeamImg(Request $request){
        $res = (object) null;
        try{
            $imgUpdated = TeamTrait::updateImg(new Storage(), $request, $request->id);
            $res->success = true;
            $res->updated_img = $imgUpdated;
            return response()->json($res);
        }catch(\Exception $e){
            $res->success = false;
            $res->msg = 'Hubo un error al actualizar su imagen, inténtelo nuevamente';
            return response()->json($res);
        }
    }
    public function confirmRequestToJoin(Request $request){
        $res = (object) null;
        try{
            $member = EstudianteMentorTieneEquipo::find($request->reqId);
            $isStudent = $member->estudiante_id != NULL ? true : false;
            if($isStudent){
                DB::table('estudiante_mentor_tiene_equipo')
                ->where('estudiante_id', '=', $member->estudiante_id)
                ->update(['activo'  => 0]);
            }else{
                DB::table('estudiante_mentor_tiene_equipo')
                ->where('mentor_id', '=', $member->mentor_id)
                ->update(['activo'  => 0]);
            }
            if($request->accept){
                $member->aprobado = true;
                $member->activo = true;
            }else{
                $member->activo = false;
            }
            $member->save();
            $res->success = true;
            return response()->json($res);
        }catch(\Exception $e){
            $res->success = false;
            $res->msg = 'Hubo un error, inténtelo nuevamente';
        }
    }
		public function deleteMembership($mid, $invid){
        $res = (object) null;
        try{
						if($invid !== 'null'){
							$invitation = InvitacionesEquipo::find($invid);
							$invitation->activo = false;
							$invitation->save();
						}
            $member = EstudianteMentorTieneEquipo::find($mid);
						$member->aprobado = false;
						$member->activo = false;
            $member->save();
            $res->success = true;
            return response()->json($res);
        }catch(\Exception $e){
            $res->success = false;
            $res->msg = 'Hubo un error, inténtelo nuevamente';
						// $res->err = $e->getMessage();
						return response()->json($res);
        }
    }
    public function requestJoin(Request $request){
        // Verificar que el estudiante no pertenece a ningun otro equipo ya
        $res  = (object) null;
        try{
						// Verificar edad del usuario en base a la division del equipo
						// si es que estos concuerdan
						$verify = UserTrait::verifyAge($request->idUser, $request->idTeam, 'JOIN');
						if($verify['success']){
							if(TeamTrait::requestJoinTeam($request->idUser, $request->idTeam, $request->role)){
	                $res->msg = 'Tu solicitud fue enviada con exito';
	                $res->success = true;
	            }else{
	                $res->msg = 'Ya enviaste una solicitud al equipo, revisa tu correo electrónico por una respuesta';
	                $res->success = false;
	            }
						}else{
							$res->success = $verify['success'];
							$res->msg = $verify['msg'];
						}
            return response()->json($res);
        }catch(\Exception $e){
            $res->msg = 'Hubo un error al realizar la solicitud, inténtelo nuevamente';
						$res->err = $e->getMessage();
            $res->success = false;
            return response()->json($res);
        }
    }
    public function sendInvitation(Request $request){
        $res = (object) null;
        $user = Usuario::find($request->uid);
        try{
						$verify = UserTrait::verifyAge($request->uid, $request->teamId, 'INVITATION');
						if($verify['success']){
							$invitation = [
	                'equipo_id'     => $request->teamId,
	                'mentor_id'     => NULL,
	                'estudiante_id' => NULL,
									'token'					=> md5(date('YmdHis')) . md5($request->teamId),
	            ];
	            if($request->role == 1)
	                $invitation['estudiante_id'] = $user->student->id;
	            else
	                $invitation['mentor_id'] = $user->mentor->id;
	            InvitacionesEquipo::create($invitation);
							$res->success = true;
						}else{
							$res->success = $verify['success'];
							$res->msg = $verify['msg'];
						}
            return response()->json($res);
        }catch(\Exception $e){
            $res->success = false;
						$res->err = $e->getMessage();
            $res->msg = 'Hubo un error al enviar la invitación';
            return response()->json($res);
        }
    }
    public function hasRequestSentTo($teamId, $uid, $role){
        // Buscar los ids de los estudiantes o mentores, a los que se les ha mandado una invitacion para formar parte del equipo, para inhabilitar el boton de invitacion
        $res = (object) null;
        try{
            $user = Usuario::find($uid);
            if($role == 1){
                $hasRequest = EstudianteMentorTieneEquipo::where([['equipo_id', '=', $teamId], ['estudiante_id', '=', $user->student->id], ['activo', '=', 1] ])->first();
            }else if($role == 2){
                $hasRequest = EstudianteMentorTieneEquipo::where([['equipo_id', '=', $teamId], ['mentor_id', '=', $user->mentor->id], ['activo', '=', 1] ])->first();
            }
            $res->success = true;
            $res->isSent = $hasRequest == NULL ? false : true;
            return response()->json($res);
        }catch(\Exception $e){
            $res->success = false;
            $res->msg = 'Hubo un error al comprobar la invitación del usuario';
            return response()->json($res);
        }
    }
    public function confirmInvitation(Request $request){
        $res = (object) null;
        $invitation = InvitacionesEquipo::find($request->invitationId);
        try{
            if(!$request->accept){
                $invitation->activo = false;
                $invitation->save();
                $res->success = true;
                $res->msg = 'La invitación fue rechazada con éxito';
                return response()->json($res);
            }
            $member = [
                'equipo_id'     => $request->teamId,
                'mentor_id'     => NULL,
                'estudiante_id' => NULL,
            ];
            if($invitation->estudiante_id != NULL){
                $user = Estudiante::find($invitation->estudiante_id);
                $member['estudiante_id'] = $user->id;
                $member['lider_equipo'] = false;
            }else{
                $user = Mentor::find($invitation->mentor_id);
                $member['mentor_id'] = $user->id;
                $member['lider_equipo'] = true;
            }
            $invitation->confirmacion = true;
            $invitation->save();
            $member['aprobado'] = true;
            EstudianteMentorTieneEquipo::create($member);
            $res->success = true;
						$res->team_id = $request->teamId;
            return response()->json($res);
        }catch(\Exception $e){
            $res->success = false;
            $res->msg = 'Hubo un error al rechazar la invitación';
            return response()->json($res);
        }
    }
		public function confirmEmailInvitation($invitationId, $token, $teamid, $bool){
        $res = (object) null;
        $invitation = InvitacionesEquipo::find($invitationId);
        try{
						if($invitation->token != $token || $invitation->activo == 0){
							return redirect(config('constants.STATE.LOCAL_URL'));
						}
            if($bool == 'REFUSE'){
                $invitation->activo = false;
                $invitation->save();
                return redirect(config('constants.STATE.LOCAL_URL') . 'invitacion-rechazada');
            }
            $member = [
                'equipo_id'     => $teamid,
                'mentor_id'     => NULL,
                'estudiante_id' => NULL,
            ];
            if($invitation->estudiante_id != NULL){
                $user = Estudiante::find($invitation->estudiante_id);
                $member['estudiante_id'] = $user->id;
                $member['lider_equipo'] = false;
            }else{
                $user = Mentor::find($invitation->mentor_id);
                $member['mentor_id'] = $user->id;
                $member['lider_equipo'] = true;
            }
            $invitation->confirmacion = true;
            $invitation->save();
            $member['aprobado'] = true;
            EstudianteMentorTieneEquipo::create($member);
						return redirect(config('constants.STATE.LOCAL_URL') . 'invitacion-aceptada');
        }catch(\Exception $e){
            $res->success = false;
            $res->msg = 'Hubo un error al rechazar la invitación';
            return response()->json($res);
        }
    }

		public function deleteTeam($idTeam){
			$res = (object) null;
			DB::beginTransaction();
			try{
				$team = Equipo::find($idTeam);
				$team->activo = false;
				$team->save();
				DB::table('estudiante_mentor_tiene_equipo')
						->where('equipo_id', '=', $idTeam)
						->update(['activo' => 0, 'aprobado' => 0]);
				DB::table('invitaciones_equipo')
						->where('equipo_id', '=', $idTeam)
						->update(['activo' => 0, 'confirmacion' => 0]);
				$res->success = true;
				$res->msg = 'Equipo eliminado con exito';
				DB::commit();
				return response()->json($res);
			}catch(\Exception $e){
				DB::rollBack();
				$res->success = false;
				$res->msg = 'Hubo un error al borrar al equipo';
				$res->err = $e->getMessage();
				return response()->json($res);
			}
		}
}
