<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Estudiante;
use App\Models\Responsable;
use DB;

use App\Traits\UserTrait as UserTrait;

class StudentCtrl extends Controller
{
	use UserTrait;
    //
		public function index($page){
		    $QT_PAGE = 15;
		    $PAGE = $page;
		    $TOTAL = DB::table('estudiante')
		                ->join('usuario', 'estudiante.usuario_id', '=', 'usuario.id')
		                ->where('usuario.activo', '=', '1')
		                ->count();
		    $TOTAL_PAGES = ceil($TOTAL / $QT_PAGE);
		    $dbStudents = DB::table('estudiante')
		                  ->join('usuario', 'estudiante.usuario_id', '=', 'usuario.id')
		                  ->where('usuario.activo', '=', '1')
		                  ->skip(($PAGE - 1) * $QT_PAGE)
		                  ->take($QT_PAGE)
		                  ->get();
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
		// public function index($page){
		//     $QT_PAGE = 15;
		//     $PAGE = $page;
		//     $TOTAL = DB::table('estudiante')
		//                 ->join('usuario', 'estudiante.usuario_id', '=', 'usuario.id')
		//                 ->where('usuario.activo', '=', '1')
		//                 ->count();
		//     $TOTAL_PAGES = ceil($TOTAL / $QT_PAGE);
		//     $dbStudents = DB::table('estudiante')
		//                   ->join('usuario', 'estudiante.usuario_id', '=', 'usuario.id')
		//                   ->where('usuario.activo', '=', '1')
		//                   ->skip($PAGE - 1)
		//                   ->take($QT_PAGE)
		//                   ->get();
		//     $students = [];
		//     $res = (object) null;
		//     try{
		//         foreach ($dbStudents as $student) {
		//           $students[] = UserTrait::userData($student->usuario_id);
		//         }
		//         $res->success = true;
		//         $res->students = $students;
		//         $res->pages = $TOTAL_PAGES;
		//         return response()->json($res);
		//     }catch(\Exception $e){
		//         $res->success = false;
		//         $res->err = $e->getMessage();
		//         $res->msg = 'Hubo un error al cargar los datos de los estudiantes';
		//         return response()->json($res);
		//     }
		// }
		// public function indexAdmin(){
		//     $dbStudents = DB::table('estudiante')
		//                   ->join('usuario', 'estudiante.usuario_id', '=', 'usuario.id')
		//                   ->where('usuario.activo', '=', '1')
		//                   ->get();
		//     $students = [];
		//     $res = (object) null;
		//     try{
		//         foreach ($dbStudents as $student) {
		//           $students[] = UserTrait::userData($student->usuario_id);
		//         }
		//         $res->success = true;
		//         $res->students = $students;
		//         $res->pages = $TOTAL_PAGES;
		//         return response()->json($res);
		//     }catch(\Exception $e){
		//         $res->success = false;
		//         $res->err = $e->getMessage();
		//         $res->msg = 'Hubo un error al cargar los datos de los estudiantes';
		//         return response()->json($res);
		//     }
		// }
}
