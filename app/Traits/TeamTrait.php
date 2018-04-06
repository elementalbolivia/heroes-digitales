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
use Storage;

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
		$teamData['app_doc'] 		= 	$team->project->resumen_archivo;
		$teamData['app_apk'] 		= $team->project->codigo_fuente_archivo;
		$teamData['img']	 		= $team->imagen;
		$teamData['is_aproved'] 	= $team->project->proyecto_aprobado == 1 ? true : false;
		$teamData['created_at'] 	= $team->fecha_creacion;
		$teamData['youtube_videos'] = self::getVideos($team->project);
		$teamData['division'] 	= $team->division($team->division_id);
		$teamData['category'] 	= $team->project->category($team->project->categoria_id);
		$teamData['city'] 		= $team->city($team->ciudad_id);
		foreach ($team->members as $member) {
			if($member->aprobado == 1 and $member->activo == 1){
				$isStudent = $member->estudiante_id != NULL ? true : false;
				if($isStudent){
					$counterStudents++;
					$userMember = Usuario::find(Estudiante::find($member->estudiante_id)->usuario_id);
				}else{
					$counterMentor++;
					$userMember = Usuario::find(Mentor::find($member->mentor_id)->usuario_id);
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
		// Init counters
		$counterMentorsLP = 0;
		$counterMentorsEA = 0;
		$counterStudentsLP = 0;
		$counterStudentsEA = 0;
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
		$teamData['members']['mentors'] = [];
		$teamData['members']['students'] = [];
		foreach ($team->members as $member) {
			if($member->aprobado == 1 and $member->activo == 1){
				$isStudent = $member->estudiante_id != NULL ? true : false;
				if($isStudent){
					$userMember = Usuario::find(Estudiante::find($member->estudiante_id)->usuario_id);
					$teamData['members']['students'][] = [
						'names'			=> $userMember->nombres,
						'lastnames'		=> $userMember->apellidos,
						'school'		=> $userMember->student->colegio != NULL ? $userMember->student->colegio : 'Sin colegio',
						'age'		=> $userMember->getAge(),
						'gender'		=> $userMember->genero_id == 1 ? 'Femenino' : 'Masculino',
						'birth_date'		=> $userMember->fecha_nacimiento,
						'division'	=> UserTrait::division($userMember),
						'city'	=> $userMember->ciudad_id == 1 ? 'La Paz' : 'El Alto',
						'user_id'		=> $userMember->id,
						'is_student'	=> $isStudent,
						'is_leader'		=> $member->lider_equipo == 1 ? true : false,
						'is_aproved'	=> $member->aprobado == 1 ? true : false,
						'created_at'	=> $member->fecha_creacion,
						'image'			=> $userMember->image != NULL ? $userMember->image->nombre_archivo : NULL,
					];
					$counterStudents++;
					if($userMember->ciudad_id == 1)
						$counterStudentsLP++;
					else
						$counterStudentsEA++;

				}else{
					$userMember = Usuario::find(Mentor::find($member->mentor_id)->usuario_id);
					$teamData['has_mentor'] = true;
					$teamData['members']['mentors'][] = [
						'names'			=> $userMember->nombres,
						'lastnames'		=> $userMember->apellidos,
						'gender'		=> $userMember->genero_id == 1 ? 'Femenino' : 'Masculino',
						'age'		=> $userMember->getAge(),
						'birth_date'		=> $userMember->fecha_nacimiento,
						'city'	=> $userMember->ciudad_id == 1 ? 'La Paz' : 'El Alto',
						'user_id'		=> $userMember->id,
						'is_student'	=> $isStudent,
						'is_leader'		=> $member->lider_equipo == 1 ? true : false,
						'is_aproved'	=> $member->aprobado == 1 ? true : false,
						'created_at'	=> $member->fecha_creacion,
						'image'			=> $userMember->image != NULL ? $userMember->image->nombre_archivo : NULL,
					];
					$counterMentor++;
					if($userMember->ciudad_id == 1){
						$counterMentorsLP++;
					}else{
						$counterMentorsEA++;
					}
				}
			}
		}
		$teamData['has_mentor'] = isset($teamData['has_mentor']) ? true : false;
		$teamData['is_full_students'] = $counterStudents >= 4 ? true : false;
		$teamData['is_full_mentors'] = $counterMentor >= 2 ? true : false;
		$teamData['num_students'] = $counterStudents;
		$teamData['num_mentors'] = $counterMentor;
		//Counters
		$teamData['num_mentors_ea'] = $counterMentorsEA;
		$teamData['num_students_ea'] = $counterStudentsEA;
		$teamData['num_mentors_lp'] = $counterMentorsLP;
		$teamData['num_students_lp'] = $counterStudentsLP;

		return $teamData;
	}
	public static function getVideos($Project){
		$videos = [];
		foreach ($Project->videoProyecto as $video) {
			$videos[] = [
				'id' => $video->id,
				'youtube_url' => $video->youtube_url,
				'is_demo'		=> $video->es_demo,
				'is_team'		=> $video->es_equipo,
			];
		}
		if (empty($videos)){
			$videos = [
				['id' => null, 'youtube_url' => '', 'is_demo' => true, 'is_team' => false],
				['id'	=> null, 'youtube_url' => '', 'is_demo' => false, 'is_team' => true],
			];
		}else if(count($videos) == 1){
			if($videos[0]['is_team']){
				$is_demo = array(['id' => null, 'youtube_url' => '', 'is_demo' => true, 'is_team' => false]);
				array_splice($videos, 0, 0, $is_demo);
			}else{
				$is_demo = ['id' => null, 'youtube_url' => '', 'is_demo' => false, 'is_team' => true];
				array_push($videos, $is_demo);
			}
		}else{
			if($videos[0]['is_team']){
				// swap
				$temp = $videos[1]; //demo
				$videos[1] = $videos[0]; // team
				$videos[0] = $temp;
			}
		}
		return $videos;
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
	public static function uploadAppDoc($file, $teamId){
		$team = Equipo::findOrFail($teamId);
		$project = $team->project;
		$name = 'resumen_app_'
						. md5(date('YmdHis'))
						. md5($project->id)
						. '.'
						. pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);

    Storage::disk('uploads')
        ->put('doc_apps/'.$name, file_get_contents($file->getRealPath()));
		$project->resumen_archivo = $name;
		$project->save();
    return $name;
	}
	public static function uploadApk($file, $teamId){
		$team = Equipo::findOrFail($teamId);
		$project = $team->project;
		$apk = '@pp'
						. md5(date('YmdHis'))
						. md5($project->id)
						. '.'
						. pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
    Storage::disk('uploads')
        ->put('apps_apks/'.$apk, file_get_contents($file->getRealPath()));
		$project->codigo_fuente_archivo = $apk;
		$project->save();
    return $apk;
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
	public static function queryTeams($cities, $divisions, $teamName){
		$match = (object) null;
		$citiesIds = [];
		$divisionsIds = [];
		foreach ($cities as $city) {
			if($city == 'La Paz') $citiesIds[] = 1;
			else $citiesIds[] = 2;
		}
		foreach ($divisions as $division) {
			if(substr($division, 0, 1) == 'J') $divisionsIds[] = 1;
			else $divisionsIds[] = 2;
		}
		// var_dump($citiesIds);
		// var_dump($divisionsIds);
		// die();
		// $QT_PAGE = $quantityPerPage;
		// $PAGE = $page;
		// $withTeam = $request->withTeam == "true" ? true : false;
		if($teamName !== NULL || isset($teamName)){
			$match->rows = DB::table('equipo')
						 ->select('equipo.id')
						 ->where('equipo.nombre_equipo', 'like', '%'. $teamName .'%')
						 ->distinct('equipo.id')
						 ->get();
			 return $match;
		}
		if(count($citiesIds) !== 0 && count($divisionsIds) !== 0){
			 $match->rows = DB::table('equipo')
			 				->select('equipo.id')
							->where('equipo.activo', '=', 1)
							->whereIn('equipo.ciudad_id', $citiesIds)
							->whereIn('equipo.division_id', $divisionsIds)
							->get();
		}else if(count($citiesIds) !== 0 && count($divisionsIds) === 0){
			$match->rows = DB::table('equipo')
						 ->select('equipo.id')
						 ->where('equipo.activo', '=', 1)
						 ->whereIn('equipo.ciudad_id', $citiesIds)
						 ->get();
		}else if(count($citiesIds) === 0 && count($divisionsIds) !== 0){
			$match->rows = DB::table('equipo')
						 ->select('equipo.id')
						 ->where('equipo.activo', '=', 1)
						 ->whereIn('equipo.division_id', $divisionsIds)
						 ->get();
		}else if(count($citiesIds) === 0 && count($divisionsIds) === 0){
			$match->rows = DB::table('equipo')
						 ->select('equipo.id')
						 ->where('equipo.activo', '=', 1)
						 ->get();
		}
		return $match;
	}
	public static function isDeadlineOut(){
		$date = date('Y-m-d H:i:s');
		return $date > '2018-04-06 16:59:59';
	}
}
