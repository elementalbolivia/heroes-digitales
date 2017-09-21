<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Traits\UserTrait;
use DB;


class JudgeCtrl extends Controller
{
    use UserTrait;
	public function index(){
		$judges = [];
        $res = (object) null;
        try{
            foreach (Usuario::all() as $user) {
                if($user->role($user->id)->rol_id == 3){
                    $judges[] = UserTrait::userData($user->id);
                }
            }
            $res->success = true;
            $res->judges = $judges;
            return response()->json($res);
        }catch(\Exception $e){
            $res->success = false;
            $res->msg = 'Hubo un error al cargar los datos de los estudiantes';
            return response()->json($res);
        }
	}
}