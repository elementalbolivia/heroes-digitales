<?php

namespace App\Traits;

use App\Models\Usuario;
use App\Models\Estudiante;
use App\Models\Mentor;
use App\Models\Equipo;
use App\Models\EstudianteMentorTieneEquipo;
use App\Models\InvitacionesEquipo;
use App\Traits\EmailTrait;
use DB;

date_default_timezone_set('America/La_Paz');

trait TeamTrait{
	use EmailTrait;
	public static function teamInfo($id){
		$teamData = [];
		$counterStudents = 0;
		$counterMentor = 0;
		$team = Equipo::find($id);
		$teamData['id'] 			= $team->id;
		$teamData['team_name'] 		= $team->nombre_equipo;
		$teamData['project_name'] 	= $team->project->nombre_proyecto;
		$teamData['project_desc'] 	= $team->project->descripcion;
		$teamData['business'] 		= $team->modelo_negocio_archivo;
		$teamData['img']	 		= $team->imagen;
		$teamData['is_aproved'] 	= $team->project->proyecto_aprobado == 1 ? true : false;
		$teamData['created_at'] 	= $team->fecha_creacion;
		$teamData['division'] 	= $team->division($team->division_id);
		$teamData['category'] 	= $team->project->category($team->project->categoria_id);
		$teamData['city'] 		= $team->city($team->ciudad_id);
		foreach ($team->members as $member) {
			if($member->aprobado == 1){
				$isStudent = $member->estudiante_id != NULL ? true : false;
				if($isStudent){
					$counterStudents++;
					$userMember = Usuario::find(Estudiante::find($member->estudiante_id)->usuario_id);
				}else{
					$userMember = Usuario::find(Mentor::find($member->mentor_id)->usuario_id);
					$counterMentor++;
					$teamData['has_mentor'] = true;
				}
				$teamData['members'][] = [
					'names'			=> $userMember->nombres,
					'lastnames'		=> $userMember->apellidos,
					'user_id'		=> $userMember->id,
					'is_student'	=> $isStudent,
					'is_leader'		=> $member->lider_equipo == 1 ? true : false,
					'is_aproved'	=> $member->aprobado == 1 ? true : false,
					'created_at'	=> $member->fecha_creacion,
					'image'			=> $userMember->image != NULL ? $userMember->image->nombre_archivo : NULL,
				];
			}
		}
		$teamData['has_mentor'] = isset($teamData['has_mentor']) ? true : false;
		$teamData['is_full_students'] = $counterStudents >= 4 ? true : false;
		$teamData['is_full_mentors'] = $counterMentor >= 2 ? true : false;
		return $teamData;
	}
	public static function teamInfoAdmin($id){
		$teamData = [];
		$counterStudents = 0;
		$counterMentor = 0;
		$team = Equipo::find($id);
		$teamData['id'] 			= $team->id;
		$teamData['team_name'] 		= $team->nombre_equipo;
		$teamData['project_name'] 	= $team->project->nombre_proyecto;
		$teamData['project_desc'] 	= $team->project->descripcion;
		$teamData['business'] 		= $team->modelo_negocio_archivo;
		$teamData['img']	 		= $team->imagen;
		$teamData['is_aproved'] 	= $team->project->proyecto_aprobado == 1 ? true : false;
		$teamData['created_at'] 	= $team->fecha_creacion;
		$teamData['division'] 	= $team->division($team->division_id);
		$teamData['category'] 	= $team->project->category($team->project->categoria_id);
		$teamData['city'] 		= $team->city($team->ciudad_id);
		foreach ($team->members as $member) {
			if($member->aprobado == 1){
				$isStudent = $member->estudiante_id != NULL ? true : false;
				if($isStudent){
					$userMember = Usuario::find(Estudiante::find($member->estudiante_id)->usuario_id);
					$teamData['members']['students'][] = [
						'names'			=> $userMember->nombres,
						'lastnames'		=> $userMember->apellidos,
						'gender'		=> $userMember->genero_id == 1 ? 'Femenino' : 'Masculino',
						'division'	=> UserTrait::division($userMember),
						'user_id'		=> $userMember->id,
						'is_student'	=> $isStudent,
						'is_leader'		=> $member->lider_equipo == 1 ? true : false,
						'is_aproved'	=> $member->aprobado == 1 ? true : false,
						'created_at'	=> $member->fecha_creacion,
						'image'			=> $userMember->image != NULL ? $userMember->image->nombre_archivo : NULL,
					];
					$counterStudents++;
				}else{
					$userMember = Usuario::find(Mentor::find($member->mentor_id)->usuario_id);
					$teamData['has_mentor'] = true;
					$teamData['members']['mentors'][] = [
						'names'			=> $userMember->nombres,
						'lastnames'		=> $userMember->apellidos,
						'gender'		=> $userMember->genero_id == 1 ? 'Femenino' : 'Masculino',
						'user_id'		=> $userMember->id,
						'is_student'	=> $isStudent,
						'is_leader'		=> $member->lider_equipo == 1 ? true : false,
						'is_aproved'	=> $member->aprobado == 1 ? true : false,
						'created_at'	=> $member->fecha_creacion,
						'image'			=> $userMember->image != NULL ? $userMember->image->nombre_archivo : NULL,
					];
					$counterMentor++;
				}
			}

		}
		$teamData['has_mentor'] = isset($teamData['has_mentor']) ? true : false;
		$teamData['is_full_students'] = $counterStudents >= 4 ? true : false;
		$teamData['is_full_mentors'] = $counterMentor >= 2 ? true : false;
		return $teamData;
	}
	public static function updateImg($Storage, $request, $id){
		$team = Equipo::find($id);
		$img = md5(date('YmdHis')).md5($id).'.jpg';
        $team->imagen = $img;
        $team->save();
        $Storage::disk('uploads')
            ->put('teams/'.$img, file_get_contents($request->file('newImg')->getRealPath()));
        return $img;
	}
	public static function requestJoinTeam($idUser, $idTeam, $role){
		// Verificar que no existan registros dobles de un mismo equipo y usuario
		$user = Usuario::find($idUser);
		$toJoin = [
			'equipo_id'		=> $idTeam,
			'estudiante_id'	=> NULL,
			'mentor_id'		=> NULL,
			'lider_equipo'	=> false,
			'aprobado'		=> false,
		];
		if($role == 1){
			$toJoin['estudiante_id'] = $user->student->id;
			$id = $user->student->id;
			$field = 'estudiante_id';
		}else if($role == 2){
			$toJoin['mentor_id'] = $user->mentor->id;
			$id = $user->mentor->id;
			$field = 'mentor_id';
		}
		$isSent = DB::table('estudiante_mentor_tiene_equipo')
						->where($field, '=', $id)
						->where('equipo_id', '=', $idTeam)
						->where('activo', '=', 1)
						->get();
		if($isSent != null){
			EstudianteMentorTieneEquipo::create($toJoin);
			foreach (Equipo::find($idTeam)->members as $member) {
				if($member->lider_equipo == 1){
					$isStudent = $member->estudiante_id != NULL ? true : false;
					if($isStudent){
						$leader = Usuario::find(Estudiante::find($member->estudiante_id)->usuario_id);
					}else{
						$leader = Usuario::find(Mentor::find($member->mentor_id)->usuario_id);
					}
					EmailTrait::requestEmail($user->nombres . ' ' . $user->apellidos, $leader->correo);
				}
			}
			return true;
		}else{
			return false;
		}

	}
}
