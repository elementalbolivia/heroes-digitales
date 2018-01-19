<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Estudiante;
use App\Models\Responsable;
use DB;
use Excel;
use App\Traits\UserTrait as UserTrait;

class StudentCtrl extends Controller
{
	use UserTrait;
		public function index(Request $request, $page){
		    $QT_PAGE = 15;
		    $PAGE = $page;
				$query = $this->queryStudentsFilter($request, $PAGE, $QT_PAGE);
				$dbStudents = $query->rows;
				$TOTAL = $query->total;
				$TOTAL_PAGES = ceil($TOTAL / $QT_PAGE);
		    $students = [];
		    $res = (object) null;
		    try{
		        foreach ($dbStudents as $student) {
		          $students[] = UserTrait::userData($student->usuario_id);
		        }
		        $res->success = true;
		        $res->students = $students;
		        $res->pages = $TOTAL_PAGES;
		        return response()->json($res);
		    }catch(\Exception $e){
		        $res->success = false;
		        $res->err = $e->getMessage();
		        $res->msg = 'Hubo un error al cargar los datos de los estudiantes';
		        return response()->json($res);
		    }
		}
		public function indexAdmin($page){
			$QT_PAGE = 25;
	    $PAGE = $page;
			$res = (object) null;
			try{
			    // $TOTAL = DB::table('estudiante')
			    //             ->join('usuario', 'estudiante.usuario_id', '=', 'usuario.id')
			    //             ->count();
					// var_dump($TOTAL);
			    // $TOTAL_PAGES = ceil($TOTAL / $QT_PAGE);
			    $dbStudents = DB::table('estudiante')
			                  ->join('usuario', 'estudiante.usuario_id', '=', 'usuario.id')
			                  // ->skip(($PAGE - 1) * $QT_PAGE)
			                  // ->take($QT_PAGE)
			                  ->get();
					// var_dump(count($dbStudents));
					// var_dump(($PAGE - 1) * $QT_PAGE);
			    $students = [];
	        foreach ($dbStudents as $student) {
						// if($student->correo == 'yaecastedo@gmail.com')
							// var_dump(UserTrait::userData($student->usuario_id));
						// var_dump($count);
	          $students[] = UserTrait::userData($student->usuario_id);
	        }
	        $res->success = true;
	        $res->students = $students;
	        // $res->pages = $TOTAL_PAGES;
	        return response()->json($res);
	    }catch(\Exception $e){
	        $res->success = false;
	        $res->err = $e->getMessage();
	        $res->msg = 'Hubo un error al cargar los datos de los estudiantes';
	        return response()->json($res);
	    }
    }
    public function edit(Request $request, $id){
    	$res = (object) null;
    	$data = (object) $request->only(['names', 'lastnames', 'cellphone', 'city', 'student', 'zone', 'bio']);
    	DB::beginTransaction();
    	try{
    		UserTrait::updateUser($id, $data);
    		$res->success = true;
    		DB::commit();
    		return response()->json($res);
    	}catch(\Exception $e){
    		$res->success = false;
    		$res->msg = 'Hubo un error, inténtelo nuevamente';
    		DB::rollBack();
    		return response()->json($res);
    	}
    }
		public function getParents($id){
			$res = (object) null;
			try{
				$parent = DB::table('usuario')
								->join('estudiante', 'usuario.id', '=', 'estudiante.usuario_id')
								->join('responsable', 'estudiante.id', '=', 'responsable.estudiante_id')
	              ->select('responsable.*', 'usuario.nombres', 'usuario.apellidos', 'usuario.id as uid')
	              ->where('usuario.id', '=', $id)
	              ->first();
				if($parent == NULL){
					$user = DB::table('usuario')
											->select('nombres', 'apellidos', 'id as uid')
											->where('usuario.id', '=', $id)
											->first();
					$res->student_names = $user->nombres;
					$res->student_lastnames = $user->apellidos;
					$res->student_id = $user->uid;
					$res->msg = 'La autorización no ha sido enviada al padre/tutor';
					$res->code = 'NONE';
				}else{
					$res->parents = $parent;
					$res->student_names = $parent->nombres;
					$res->student_lastnames = $parent->apellidos;
					$res->student_id = $parent->uid;
					$res->code = 'WAITING';
				}
				$res->success = true;
				return response()->json($res);
			}catch(\Exception $e){
				$res->success = false;
				$res->msg = 'Hubo un error al obtener los datos del responsable';
				$res->err = $e->getMessage();
				return response()->json($res);
			}
		}
		public function authParent(Request $request){
			$res = (object) null;
			try{
				$responsable = Responsable::find($request->id);
				$responsable->firma_padre = $request->signature;
				$responsable->activo = true;
				$responsable->save();
				$res->success = true;
				$res->msg = 'Se actualizo la autorización del estudiante';
				return response()->json($res);
			}catch(\Exception $e){
				$res->success = false;
				$res->msg = 'Hubo un error al actualizar la autorización del estudiante';
				return response()->json($res);
			}
		}
		private function queryStudentsFilter($request, $page, $quantityPerPage = 15){
			$match = (object) null;
			$QT_PAGE = $quantityPerPage;
			$PAGE = $page;
			$cities = json_decode($request->city);
			$gender = json_decode($request->gender);
			$studentName = $request->studentName;
			$withTeam = $request->withTeam == "true" ? true : false;
			if($studentName != "" || isset($studentName)){
				$match->rows = DB::table('usuario')
							 ->join('estudiante', function($join){
								 $join->on('usuario.id', '=', 'estudiante.usuario_id');
							 })
							 ->where('usuario.activo', '=', 1)
							 ->where('usuario.nombres', 'like', '%'. $studentName .'%')
							 ->orWhere('usuario.apellidos', 'like', '%'.$studentName.'%')
							 ->skip(($PAGE - 1) * $QT_PAGE)
							 ->take($QT_PAGE)
							 ->get();
				 $match->total =  DB::table('usuario')
							 ->join('estudiante', function($join){
								 $join->on('usuario.id', '=', 'estudiante.usuario_id');
							 })
							 ->where('usuario.activo', '=', 1)
							 ->where('usuario.nombres', 'like', '%'. $studentName .'%')
							 ->orWhere('usuario.apellidos', 'like', '%'.$studentName.'%')
							 ->count();
				 return $match;
			}
			if(count($cities) > 0 )
				if($cities[0] == "")
					unset($cities[0]);
			if(count($gender) > 0 )
				if($gender[0] == "")
					unset($gender[0]);
			if(count($cities) != 0 && $withTeam){
				 $match->rows = DB::table('usuario')
								->join('estudiante', function($join) {
									$join->on('usuario.id', '=', 'estudiante.usuario_id');
								})
								->join('estudiante_mentor_tiene_equipo', function($join){
									$join->on('estudiante.id', '=', 'estudiante_mentor_tiene_equipo.estudiante_id');
								})
								->where([
									'estudiante_mentor_tiene_equipo.aprobado' => 1,
									'estudiante_mentor_tiene_equipo.activo'		=> 1
								])
								->where('usuario.activo', '=', 1)
								->whereIn('usuario.ciudad_id', $cities)
								->skip(($PAGE - 1) * $QT_PAGE)
								->take($QT_PAGE)
								->get();
					$match->total =  DB::table('usuario')
								->join('estudiante', function($join) use ($cities) {
									$join->on('usuario.id', '=', 'estudiante.usuario_id');
								})
								->join('estudiante_mentor_tiene_equipo', function($join){
									$join->on('estudiante.id', '=', 'estudiante_mentor_tiene_equipo.estudiante_id');
								})
								->where('usuario.activo', '=', 1)
								->where([
									'estudiante_mentor_tiene_equipo.aprobado' => 1,
									'estudiante_mentor_tiene_equipo.activo'		=> 1
								])
								->whereIn('usuario.ciudad_id', $cities)
 								->count();
			}else if(count($cities) != 0 && !$withTeam){
				$match->rows = DB::table('usuario')
									->join('estudiante', function($join){
										$join->on('usuario.id', '=', 'estudiante.usuario_id');
									})
									->leftJoin('estudiante_mentor_tiene_equipo', function($join){
										$join->on('estudiante.id', '=', 'estudiante_mentor_tiene_equipo.estudiante_id');
								})
								->where('usuario.activo', '=', 1)
								->whereIn('usuario.ciudad_id', $cities)
								->whereNull('estudiante_mentor_tiene_equipo.estudiante_id')
								->skip(($PAGE - 1) * $QT_PAGE)
								->take($QT_PAGE)
								->get();
				$match->total = DB::table('usuario')
									->join('estudiante', function($join){
										$join->on('usuario.id', '=', 'estudiante.usuario_id');
									})
									->leftJoin('estudiante_mentor_tiene_equipo', function($join){
										$join->on('estudiante.id', '=', 'estudiante_mentor_tiene_equipo.estudiante_id');
								})
								->where('usuario.activo', '=', 1)
								->whereIn('usuario.ciudad_id', $cities)
								->whereNull('estudiante_mentor_tiene_equipo.estudiante_id')
								->count();
			}else if(count($cities) == 0){
				if(!$withTeam){
					$match->rows = DB::table('usuario')
										->join('estudiante', function($join){
											$join->on('usuario.id', '=', 'estudiante.usuario_id');
										})
										->leftJoin('estudiante_mentor_tiene_equipo', function($join){
											$join->on('estudiante.id', '=', 'estudiante_mentor_tiene_equipo.estudiante_id');
									})
									->where('usuario.activo', '=', 1)
									->whereNull('estudiante_mentor_tiene_equipo.estudiante_id')
									->skip(($PAGE - 1) * $QT_PAGE)
									->take($QT_PAGE)
									->get();
					$match->total = DB::table('usuario')
										->join('estudiante', function($join){
											$join->on('usuario.id', '=', 'estudiante.usuario_id');
										})
										->leftJoin('estudiante_mentor_tiene_equipo', function($join){
											$join->on('estudiante.id', '=', 'estudiante_mentor_tiene_equipo.estudiante_id');
									})
									->where('usuario.activo', '=', 1)
									->whereNull('estudiante_mentor_tiene_equipo.estudiante_id')
									->count();
				}else{
					$match->rows = DB::table('usuario')
								->join('estudiante', function($join){
										$join->on('usuario.id', '=', 'estudiante.usuario_id');
								})
 								->join('estudiante_mentor_tiene_equipo', function($join){
 									$join->on('estudiante.id', '=', 'estudiante_mentor_tiene_equipo.estudiante_id');
 								})
								->where('usuario.activo', '=', 1)
 								->where([
 									'estudiante_mentor_tiene_equipo.aprobado' => 1,
 									'estudiante_mentor_tiene_equipo.activo'		=> 1
 								])
 								->skip(($PAGE - 1) * $QT_PAGE)
 								->take($QT_PAGE)
 								->get();
 					$match->total = DB::table('usuario')
								->join('estudiante', function($join){
										$join->on('usuario.id', '=', 'estudiante.usuario_id');
								})
 								->join('estudiante_mentor_tiene_equipo', function($join){
 									$join->on('estudiante.id', '=', 'estudiante_mentor_tiene_equipo.estudiante_id');
 								})
								->where('usuario.activo', '=', 1)
 								->where([
 									'estudiante_mentor_tiene_equipo.aprobado' => 1,
 									'estudiante_mentor_tiene_equipo.activo'		=> 1
 								])
								->count();
				}
			}
			return $match;
		}

		public function excelReport(){
			$res = (object) null;
			try{
				$NAME = date('Y-m-d') . '-estudiantes';
				$dbStudents = DB::table('estudiante')
											->join('usuario', 'estudiante.usuario_id', '=', 'usuario.id')
											->get();
				$students = [];
				foreach ($dbStudents as $student) {
					$students[] = UserTrait::userData($student->usuario_id);
				}
				Excel::create($NAME, function($excel) use($students){
					$excel->sheet('Estudiantes', function($sheet) use($students){
						$sheet->loadView('excel_reports.students', ['students' => $students]);
					});
				})->download('xls');
				$res->success = true;
				$res->msg = 'Descargando...';
			}catch(\Exception $e){
				$res->success = false;
				$res->msg = 'Hubo un error al descargar y generar el reporte';
			}finally{
				return reponse()->json($res);
			}
		}
}
