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
    public function index(){
        $students = [];
        $res = (object) null;
        try{
            foreach (Estudiante::all() as $student) {
                if($student->user->activo == 1){
                    $students[] = UserTrait::userData($student->user->id);
                }
            }
            $res->success = true;
            $res->students = $students;
            return response()->json($res);
        }catch(\Exception $e){
            $res->success = false;
            $res->msg = 'Hubo un error al cargar los datos de los estudiantes';
            return response()->json($res);
        }
    }
		public function indexAdmin(){
        $students = [];
        $res = (object) null;
        try{
            foreach (Estudiante::all() as $student) {
                if($student->user->activo == 1){
                    $students[] = UserTrait::userData($student->user->id);
                }
            }
            $res->success = true;
            $res->students = $students;
            return response()->json($res);
        }catch(\Exception $e){
            $res->success = false;
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
