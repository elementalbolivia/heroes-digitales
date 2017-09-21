<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

use App\Traits\UserTrait as UserTrait;
use Storage;

class UserCtrl extends Controller
{
	use UserTrait;
    public function updateImg(Request $request, $id){
    	$res = (object) null;
		try{
			UserTrait::updateImg(new Storage(), $request, $id);	
			$res->success = true;
		}catch(\Exception $e){
			$res->success = false;
			$res->msg = 'Hubo un error al actualizar su imagen, inténtelo nuevamente';
		}finally{
			return response()->json($res);
		}    	
    }
}
