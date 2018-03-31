<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Traits\UserTrait;
use DB;


class ExpertCtrl extends Controller
{
    use UserTrait;
	public function index(){
		$experts = [];
        $res = (object) null;
        try{
            foreach (Usuario::all() as $user) {
                if($user->role($user->id)->rol_id ==  4){
                    $experts[] = UserTrait::userData($user->id);
                }
            }
            $res->success = true;
            $res->experts = $experts;
            return response()->json($res);
        }catch(\Exception $e){
            $res->success = false;
            $res->msg = 'Hubo un error al cargar los datos de los expertos';
            $res->err = $e->getMessage();
            return response()->json($res);
        }
	}
}
