<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Estudiante;
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
											->skip($PAGE - 1)
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
		public function indexAdmin(){
				$dbStudents = DB::table('estudiante')
											->join('usuario', 'estudiante.usuario_id', '=', 'usuario.id')
											->where('usuario.activo', '=', '1')
											->get();
        $students = [];
        $res = (object) null;
        try{
            foreach ($dbStudents as $student) {
              $students[] = UserTrait::userData($student->usuario_id);
            }
            $res->success = true;
            $res->students = $students;
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
}
