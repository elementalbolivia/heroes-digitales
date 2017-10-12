<?php

namespace App\Traits;

use App\Models\Usuario;
use App\Models\Equipo;
use App\Models\EstudianteMentorTieneEquipo;
use App\Models\Estudiante;
use App\Models\Mentor;
use App\Models\Profesion;
use App\Models\Experticia;
use App\Models\Zona;
use App\Models\MentorTieneHabilidad;
use Carbon\Carbon;
use DB;

date_default_timezone_set('America/La_Paz');


trait UserTrait{
	// ################################
	// #######  MAIN USER DATA   ######
	// ################################
	/**
	 * userData: Devuelve la información basica que es requerida por cada
	 * 			rol de usuario.
	 * @param  int $uid: ID de cada usuario
	 * @return object $userData: Objeto conteniendo toda la
	 *                           informacion del usuario.
	 */
	public static function userData($uid){
		$userData = [];
		$userData = self::basicUserInfo($uid);
		// Informacion especifica por rol de usuario
		if($userData[0]['role_id'] == 1){
			$userData[0]['student'] = self::studentData($userData[1]);
			$userData[0]['has_team'] = isset($userData[0]['student']['has_team']) ? $userData[0]['student']['has_team'] : false;
			$userData[0]['min_fields'] = $userData[0]['student']['authorization']
										&& $userData[0]['image']
										&& $userData[0]['bio']
										&& $userData[0]['terms_use'] ? true : false;
			$userData[0]['invitations'] = self::invitations($userData[1], $userData[0]['role_id']);
			$mTeam = DB::table('estudiante_mentor_tiene_equipo')
						->select('equipo_id')
						->where([['estudiante_id', '=', $userData[1]->student->id],
								 ['aprobado', '=', 1]])
						->first();
			$userData[0]['has_team'] = $mTeam == NULL ? false : true;
			if($mTeam != null)
				$userData[0]['team'] = self::teamUserData($mTeam);
		}else if($userData[0]['role_id'] == 2){
			$userData[0]['mentor'] = self::mentorData($userData[1]);
			$userData[0]['has_team'] = isset($userData[0]['mentor']['has_team']) ? $userData[0]['mentor']['has_team'] : false;
			$userData[0]['min_fields'] = $userData[0]['image']
										&& $userData[0]['bio']
										&& $userData[0]['terms_use'] ? true : false;
			$userData[0]['invitations'] = self::invitations($userData[1], $userData[0]['role_id']);
			$mTeam = DB::table('estudiante_mentor_tiene_equipo')
						->select('equipo_id')
						->where([['mentor_id', '=', $userData[1]->mentor->id],
								 ['aprobado', '=', 1]])
						->first();
			$userData[0]['has_team'] = $mTeam == NULL ? false : true;
			if($mTeam != null)
				$userData[0]['team'] = self::teamUserData($mTeam);
		}else if($userData[0]['role_id'] == 3){
			$userData[0]['judge'] = self::judgeData($userData[1]);
		}else if($userData[0]['role_id'] == 4){
			$userData[0]['expert'] = self::expertData($userData[1]);
		}else{
			//TODO
		}
		return (object)$userData[0];
	}
	// ################################
	// ####### USER SPECIFIC DATA #####
	// ################################
	/**
	 * basicUserInfo: Funcion estatica que obtiene la informacion
	 * 					que comparten todos los usuarios mediante
	 * 					la tabla 'usuario'
	 * @param  [int] $uid: ID del usuario
	 * @return [array]: Compuesto por el array $userData (el que tiene
	 *                   toda la informacion) y $user (instancia del
	 *                   objeto Model::Usuario)
	 */
	protected static function basicUserInfo($uid){
		$user = Usuario::find($uid);
		// Informacion compartida por todos los usuarios
		$userData['id'] 		= $user->id;
		$userData['names'] 		= $user->nombres;
		$userData['lastnames'] 	= $user->apellidos;
		$userData['email']		= $user->correo;
		$userData['cellphone'] 	= $user->celular;
		$userData['terms_use'] 	= $user->terminos_uso == 1 ? true : false;
		$userData['birth_date'] = $user->fecha_nacimiento;
		$userData['created_at'] = $user->fecha_creacion->toDateTimeString();
		$userData['is_active'] = $user->activo;
		$userData['city'] 		= $user->city($user->ciudad_id);
		$userData['genre'] 		= $user->genre($user->genero_id);
		$userData['zone'] 		= $user->zone != NULL ? $user->zone->nombre : NULL;
		$userData['image'] 	= $user->image != NULL ? [
								'id'	=> $user->image->id,
								'name'	=> $user->image->nombre_archivo
								] : false;
		$userData['bio'] 		= $user->biography != NULL ? [
								'id'	=> $user->biography->id,
								'name'	=> $user->biography->descripcion
								] : false;
		$userData['role_id'] = $user->role($user->id)->rol_id;
		return [$userData, $user];
	}
	/**
	 * teamUserData: Retorna la informacion de equipo por si el usuario
	 * 					tiene un equipo o ha recibido una invitacion
	 * @param  [type] $mTeam [description]
	 * @return [type]        [description]
	 */
	private static function teamUserData($mTeam){
		$team = Equipo::find($mTeam->equipo_id);
		$teamData = [];
		$teamData['team']['id'] 				= $team->id;
		$teamData['team']['team_name'] 		= $team->nombre_equipo;
		$teamData['team']['project_name'] 	= $team->project->nombre_proyecto;
		$teamData['team']['project_desc'] 	= $team->project->descripcion;
		$teamData['team']['business'] 	= $team->modelo_negocio_archivo;
		$teamData['team']['is_aproved'] 	= $team->project->proyecto_aprobado == 1 ? true : false;
		$teamData['team']['created_at'] 	= $team->fecha_creacion;
		$teamData['team']['division'] 	= $team->division($team->division_id);
		$teamData['team']['city'] 		= $team->city($team->ciudad_id);
		foreach ($team->members as $member) {
			$isStudent = $member->estudiante_id != NULL ? true : false;
			if($isStudent)
				$userMember = Usuario::find(Estudiante::find($member->estudiante_id)->usuario_id);
			else
				$userMember = Usuario::find(Mentor::find($member->mentor_id)->usuario_id);
			if($member->aprobado == 1 && $mTeam->equipo_id == $member->equipo_id){
				$teamData['team']['members'][] = [
					'names'			=> $userMember->nombres,
					'lastnames'		=> $userMember->apellidos,
					'user_id'		=> $userMember->id,
					'is_student'	=> $isStudent,
					'is_leader'		=> $member->lider_equipo == 1 ? true : false,
					'is_aproved'	=> $member->aprobado == 1 ? true : false,
					'created_at'	=> $member->fecha_creacion->toDateTimeString(),
				];
			}else if($member->activo == 1 && $member->aprobado == 0){
				$teamData['team']['requests'][] = [
					'names'			=> $userMember->nombres,
					'lastnames'		=> $userMember->apellidos,
					'request_id'	=> $member->id,
					'is_student'	=> $isStudent,
					'is_leader'		=> $member->lider_equipo == 1 ? true : false,
					'created_at'	=> $member->fecha_creacion->toDateTimeString(),
				];
			}
		}
		$teamData['team']['is_full'] = count($teamData['team']['members']) == 5 ? true : false;
		return $teamData['team'];
	}
	private static function invitations($user, $role){
		if($role == 1)
			$user = $user->student;
		else
			$user = $user->mentor;
		$invitationsData['invitations'] = [];
		foreach ($user->invitationsToTeam as $invitation) {
			if($invitation->pivot->activo == 0)
				continue;
			$invitationsData['invitations'][] = [
					'invitation_id'	=> $invitation->pivot->id,
					'team_id'		=> $invitation->id,
					'team_name'		=> $invitation->nombre_equipo,
					'created_at'	=> $invitation->pivot->fecha_creacion,
				];
		}
		return $invitationsData['invitations'];
	}
	// ################################
	// #######  USER ROLE DATA   ######
	// ################################
	protected static function studentData($user){
		// TODO
		$student = $user->student;
		$studentData = [];
		$studentData['authorization'] = $student->responsable != NULL ? [
					'id'		=> $student->responsable->id,
					'signature'	=> $student->responsable->firma,
				] : false;
		$studentData['school'] = $student->colegio != NULL ? $student->colegio : NULL;
		return $studentData;
	}
	private static function mentorData($user){
		// TODO
		$mentor = $user->mentor;
		$mentorData = [];
		$mentorData['job'] = $user->proffesionalData->trabajo;
		$mentorData['profession'] = $user->proffesionalData->profesion;
		$mentorData['work_place'] = $user->proffesionalData->organizacion;
		$mentorData['skills'] = [];
		foreach ($mentor->skills as $skill) {
			if($skill->pivot->experticia_id == 1)
				continue;
			$mentorData['skills'][] = [
				'skill_id' 		=> $skill->id,
				'skill_name'	=> $skill->nombre,
				'skill_level_id'	=> Experticia::skillLevel($skill->pivot->experticia_id)['id'],
				'skill_level'		=> Experticia::skillLevel($skill->pivot->experticia_id)['nombre'],
			];
		}
		return $mentorData;
	}
	private static function expertData($user){
		// TODO
		$expert = $user->expert;
		$expertData = [];
		$expertData['job'] = $user->proffesionalData->trabajo;
		$expertData['profession'] = $user->proffesionalData->profesion;
		$expertData['work_place'] = $user->proffesionalData->organizacion;
		$expertData['cv'] = storage_path().'/app/public/curriculums/' . $user->proffesionalData->cv;
		$expertData['cv'] = storage_path().'/app/public/curriculums/' . $user->proffesionalData->cv;
		$expertData['social_network'] = $user->proffesionalData->red_social_url;
		return $expertData;
	}
	private static function judgeData($user){
		// TODO
		$judgeData = $user->expert;
		$judgeData = [];
		$judgeData['job'] = $user->proffesionalData->trabajo;
		$judgeData['profession'] = $user->proffesionalData->profesion;
		$judgeData['work_place'] = $user->proffesionalData->organizacion;
		$judgeData['cv'] = $user->proffesionalData->cv;
		$judgeData['social_network'] = $user->proffesionalData->red_social_url;

		return $judgeData;
	}
	// ################################
	// #######  USER UPDATES     ######
	// ################################
	public static function updateUser($uid, $data){
		// Cambios en usuario
		$user = Usuario::find($uid);
		$user->nombres = $data->names;
		$user->apellidos = $data->lastnames;
		$user->celular = $data->cellphone;
		$user->ciudad_id = $data->city['id'];
		$user->save();
		// Cambios en biografia
		if($user->biography == null ){
			$user->biography()->create([
				'descripcion'	=> $data->bio,
			]);
		}else{
			$user->biography->descripcion = $data->bio;
			$user->biography->save();
		}
		if($user->zone == null ){
			$user->zone()->create([
				'nombre'	=> $data->zone,
			]);
		}else{
			$user->zone->nombre = $data->zone;
			$user->zone->save();
		}

		if($user->role($user->id)->rol_id == 1){
			self::updateStudent($user, $data);
		}else if($user->role($user->id)->rol_id == 2){
			self::updateMenthor($user, $data);
		}else if($user->role($user->id)->rol_id == 3){
			self::updateStudent($user, $data);
		}else if($user->role($user->id)->rol_id == 4){
			self::updateStudent($user, $data);
		}
	}
	private static function updateStudent($user, $data){
		// Actualizacion del estudiante
		$user->student->colegio = $data->student['school'];
		$user->student->save();
	}
	private static function updateMenthor($user, $data){
		// Actualizacion del mentor
		$user->proffesionalData->trabajo = $data->mentor['job'];
		$user->proffesionalData->organizacion = $data->mentor['work_place'];
		$user->proffesionalData->profesion = $data->mentor['profession'];
		$user->proffesionalData->save();
		foreach ($data->skills as $skill) {
	    	if(isset($skill['expertise']))
	    		MentorTieneHabilidad::firstOrCreate(
	    			['mentor_id'		=> $user->mentor->id,
	    			 'habilidad_id'		=> $skill['id']],
	    			['experticia_id'	=> $skill['expertise']['id']]
	    		);
    	}

	}
	public static function updateImg($Storage, $request, $id){
		$user = Usuario::find($id);
		$img = md5(date('YmdHis')).md5($id).'.jpg';
		if($user->image != null){
            $user->image->nombre_archivo = $img;
            $user->image->save();
        }else{
        	$user->image()->create([
        		'nombre_archivo'	=> $img
        	]);
        }
        $Storage::disk('uploads')
            ->put('users/'.$img, file_get_contents($request->file('img')->getRealPath()));
	}

}
