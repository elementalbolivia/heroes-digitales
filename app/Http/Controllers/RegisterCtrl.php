<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Registration;
use App\Models\Usuario;
use App\Models\Estudiante;
use App\Models\Mentor;
use App\Models\Juez;
use App\Models\Experto;
use App\Models\UsuarioTieneRol;
use App\Models\DatosProfesionales;
use App\Models\ConfirmacionEmail;
use App\Models\Equipo;
use App\Models\EstudianteMentorTieneEquipo;
use App\Models\Proyecto;
use App\Traits\UserTrait;
use Storage;
use Hash;
use DB;

date_default_timezone_set('America/La_Paz');
class RegisterCtrl extends Controller
{
	use UserTrait;
	public function newAdmin(){
        $userData = [
            'correo'            => 'diegohd@gmail.com',
            'password'          => Hash::make('admin'),
            'nombres'           => 'Diego',
            'apellidos'         => 'Bravo',
            'fecha_nacimiento'  => '1986-08-11',
            'celular'           => 7012312,
            'ciudad_id'         => 1,
            'genero_id'         => 2,
        ];
        $user = Usuario::create($userData);
        $role = [
            'usuario_id'    => $user->id,
            'rol_id'        => 6,
        ];
    	$userHasRole = UsuarioTieneRol::create($role);
        $user->admin()->create([]);
    }
	/**
	 * [create description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
    public function create(Request $request){
    	DB::beginTransaction();
    	try{
    		if(Usuario::where('correo', $request->email)
    				->first() != null){
    			return response()->json([
    				'success'	=> false,
    				'msg'		=> 'Esta cuenta existe actualmente, intente con una nueva'
    			]);
    		}
    		$res = (object) null;
				$fecha_nac = $request->birthDate['year'] . '-'. $request->birthDate['month'] . '-' . $request->birthDate['day'];
				if($request->type == 'student' && !UserTrait::isDivisionAvailable($fecha_nac)){
					$res->success = false;
					$res->msg = 'Su edad supera los límites para ser registrarse como estudiante, por favor regístrese como mentor';
					$res->code = 'MENTOR';
					return response()->json($res);
				}
				// if($request->type == 'mentor' && ($fecha_nac >= '1999-08-01')){
				// 	$res->success = false;
				// 	$res->msg = 'Su edad no es apta para registrarse como mentor, por favor regístrese como estudiante';
				// 	$res->code = 'STUDENT';
				// 	return response()->json($res);
				// }
				$userData = [
	    		'correo'			=> $request->email,
	    		'password'			=> Hash::make($request->password),
	    		'nombres'			=> $request->names,
	    		'apellidos'			=> $request->lastnames,
	    		'fecha_nacimiento'	=> $fecha_nac,
	    		'celular'			=> $request->cellphone,
	    		'ciudad_id'			=> $request->cityId,
	    		'genero_id'			=> $request->genreId,
	    	];
	    	// Crear un registro en la tabla usuario
	    	$user = Usuario::create($userData);
				// Crear relacion con la zona del usuario
				$user->zone()->create(['nombre'	=> $request->zone]);
	    	// Crear array-assoc para crear el rol del usuario
	    	$role = [
	    		'usuario_id'	=> $user->id,
	    		'rol_id'		=> 0,
	    	];
	    	// Crear array-assoc de datos profesionales
	    	$proffesionalData = [
	    		'usuario_id'	=> $user->id,
	    		'profesion'	=> $request->profession,
	    		'organizacion'	=> $request->org,
	    		'trabajo'		=> $request->job,
	    		'cv'			=> NULL,
					'tamano_polera'	=> $request->shirtId,
					'red_social_url' => isset($request->socialNetwork) ? $request->socialNetwork : NULL,
	    	];
	    	if ($request->type != 'student'){
	    		$role['rol_id'] = $this->insertUser($request->type, $user, $proffesionalData, $request->file('cv'));
	    	}else{
	    		unset($proffesionalData);
	    		$role['rol_id'] = 1;
	    		$user->student()->create([
	    			'colegio'	=> $request->school,
	    		]);
	    	}
	    	// Crear rol de usuario
	    	$userHasRole = UsuarioTieneRol::create($role);
	    	if($request->type == 'judge' || $request->type == 'expert'){
					$res->success = true;
	    		$res->msg = 'Felicitaciones, su registro fue completado con éxito, revisaremos su solicitud para que pueda formar parte del equipo. Le enviaremos un correo de confirmación';
					$res->emailSended = 'NOT_SENDED';
	    	}else{
	    		// Crear un token de seguridad para verificar el mail
		    	$mailToken = md5($request->mail) . md5(date('YmdHis'));
		    	// Crear una URL para verificar al usuario
		    	$verifUrl = config('constants.API.LOCAL_URL') . 'email-verification/'. $user->id . '/' . $mailToken . '/' . $user->correo;
		    	// Crear array-assoc para crear token de confirmacion
		    	$verifToken = ConfirmacionEmail::create([
		    		'usuario_id'		=> $user->id,
		    		'token'				=> $mailToken,
		    		'fecha_creacion'	=> date('Y-m-d H:i:s'),
		    	]);
					if($request->typeRegister != null && $request->teamId != null){
						if(Equipo::find($request->teamId) == null){
							$res->success = false;
							$res->msg = 'No existe el equipo que le envío la invitación';
							DB::rollBack();
							return response()->json($res);
						}else{
							// Registrarlo en el equipo
							$invitation = new EstudianteMentorTieneEquipo;
	            if($request->type == 'student'){
	                $invitation->estudiante_id = $user->student->id;
									$invitation->mentor_id = null;
									$invitation->lider_equipo = false;
	            }else if($request->type == 'mentor'){
	                $invitation['mentor_id'] = $user->mentor->id;
									$invitation->estudiante_id = null;
									$invitation->lider_equipo = true;
							}
							$invitation->equipo_id = $request->teamId;
							$invitation->aprobado = true;
							$invitation->save();
						}
					}
		    	Mail::to($request->email)
	    			->send(new Registration($request->names, $request->lastnames, $verifUrl, 'USER_MENTOR'));
				$res->emailSended = 'SENDED';
				$res->success = true;
				$res->msg = 'Su registro fue completado con éxito, por favor revise su correo electrónico
	    				 para finalizar su inscripción';
	    	}
	    	// Enviar mail de confirmación
	    	// SI EL USUARIO ES DE TIPO JUEZ O MENTOR, ENVIAR UN MAIL
	    	// INDICANDO QUE SU PETICION SERA PROCESADA, UNA VEZ ESTA SE
	    	// REALICE, SE ENVIARA EL MAIL DEBAJO
	    	DB::commit();
	    	return response()->json($res);
    	}catch (\Exception $e){
    		DB::rollBack();
    		return response()->json([
					'err'	=> $e->getMessage(),
	    		'success' => false,
	    		'msg' => 'Hubo un error al realizar su registro, inténtelo nuevamente.',
		    ]);
    	}
    }
    private function insertUser($role, Usuario $user, $proffesionalData, $file){
    	// Verificar rol del usuario
    	if($role == 'mentor'){
    		$roleId = 2;
    		$mentor = $user->mentor()->create([]);
    	}else if($role == 'judge' || $role == 'expert'){
    		// Si el usuario es un juez o experto, debe subir su CV
    		$roleId = $role == 'judge' ? 3 : 4;
    		$cvName = md5(date('YmdHis'))
    				  . md5($user->id)
    				  . '.' . pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
	    	Storage::disk('uploads')
	    			->put('curriculums/'.$cvName,
	    			  file_get_contents($file->getRealPath()));
    		$proffesionalData['cv'] = $cvName;

    		if($roleId == 3)
    			$user->judge()->create(['tamano_polera_id' => $proffesionalData['tamano_polera']]);
    		else
    			$user->expert()->create(['tamano_polera_id' => $proffesionalData['tamano_polera']]);
    	}
			unset($proffesionalData['tamano_polera']);
    	$profesional = $user->proffesionalData()->create($proffesionalData);
    	return $roleId;
    }
    public function createTeam(Request $request){
    	$res = (object) null;
    	DB::beginTransaction();

    	try{
				$verify = UserTrait::verifyAge($request->idLeader, 0, 'CREATE', $request->divisionId);
				if(!$verify['success']){
					$res->success = $verify['success'];
					$res->msg = $verify['msg'];
					return response()->json($res);
				}
    		$user = Usuario::find($request->idLeader);
				if($user->student != NULL){
	    		$hasTeam['estudiante_id'] = $user->student->id;
	    		$hasTeam['mentor_id'] = NULL;
					$type = 'student';
	    	}else{
	    		$hasTeam['estudiante_id'] = NULL;
	    		$hasTeam['mentor_id'] = $user->mentor->id;
					$type = 'mentor';
				}
				// TODO: Verificar que no existe el mismo equipo y proyecto
	    	// y que el usuario no tiene un equipo aun
				if($user->isMemberOfAnyTeam(
						$hasTeam['estudiante_id'] != null ? $hasTeam['estudiante_id'] : $hasTeam['mentor_id'],
						$type)){
					$res->success = false;
	    		$res->msg = 'Ya perteneces a un equipo, y no puedes crear uno nuevo';
	    		return response()->json($res);
				}
	    	$file = $request->file('img');
				if($file != null){
					$img = md5(date('YmdHis'))
		    				  . md5($request->idLeader)
		    				  . '.' . pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
			    	Storage::disk('uploads')
			    			->put('teams/'.$img,
			    			  file_get_contents($file->getRealPath()));
				}else{
					$img = 'default-team.jpg';
				}
	    	$team = [
	    		'ciudad_id'		=> $request->cityId,
	    		'division_id'	=> $request->divisionId,
	    		'nombre_equipo'	=> $request->teamName,
	    		'imagen'		=> $img
	    	];
	    	// Crear equipo
	    	$createdTeam = Equipo::create($team);

				$hasTeam['equipo_id'] = $createdTeam->id;
				$hasTeam['lider_equipo'] = true;
				$hasTeam['aprobado'] = true;
	    	// Crear relacion terciaria
	    	EstudianteMentorTieneEquipo::create($hasTeam);
	    	$project = [
	    		'equipo_id'			=> $createdTeam->id,
	    	];
	    	// Crear proyecto
	    	$createdProject = Proyecto::create($project);
	    	$res->success = true;
				$res->team_id = $createdTeam->id;
	    	$res->msg = 'El equipo fue creado con éxito';
				DB::commit();
	    	return response()->json($res);
    	}catch(\Exception $e){
    		DB::rollBack();
    		$res->success = false;
    		$res->msg = 'Hubo un error al crear al equipo, inténtelo nuevamente';
    		return response()->json($res);
    	}
    }
}
