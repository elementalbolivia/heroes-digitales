<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWT\Exception;
// Traits
use App\Traits\UserTrait as UserTrait;
use DB;

date_default_timezone_set('America/La_Paz');

class DashboardCtrl extends Controller
{
    use UserTrait;
    public function userInfo($uid){
    	$res = (object) null;
    	DB::beginTransaction();
    	try{
    		$res->user = UserTrait::userData($uid);
	    	$res->success = true;
	    	DB::commit();
	    	return response()->json($res);
    	}catch(\Exception $e){
        DB::rollBack();
    		$res->success = false;
    		$res->msg = 'Hubo un error al cargar la información del usuario:' . $e->getMessage();
    		return response()->json($res);
    	}

    }
}
