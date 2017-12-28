<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\UserTrait;
use App\Models\Usuario;
use DB;

class MenthorCtrl extends Controller
{
	use UserTrait;
	public function index(){
		$mentors = [];
        $res = (object) null;
        try{
            foreach (Usuario::all() as $user) {
                if($user->role($user->id)->rol_id == 2 AND $user->activo == 1){
                    $mentors[] = UserTrait::userData($user->id);
                }
            }
            $res->success = true;
            $res->mentors = $mentors;
            return response()->json($res);
        }catch(\Exception $e){
            $res->success = false;
            $res->msg = 'Hubo un error al cargar los datos de los estudiantes';
            return response()->json($res);
        }
	}
	public function indexAdmin(){
		$mentors = [];
        $res = (object) null;
        try{
            foreach (Usuario::all() as $user) {
                if($user->role($user->id)->rol_id == 2){
                    $mentors[] = UserTrait::userData($user->id);
                }
            }
            $res->success = true;
            $res->mentors = $mentors;
            return response()->json($res);
        }catch(\Exception $e){
            $res->success = false;
            $res->msg = 'Hubo un error al cargar los datos de los estudiantes';
            return response()->json($res);
        }
	}
    public function edit(Request $request, $id){
    	$res = (object) null;
    	$data = (object) $request->only(['names', 'lastnames', 'cellphone', 'city', 'mentor', 'zone', 'bio', 'skills']);
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
