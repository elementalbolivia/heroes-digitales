<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\UserTrait;
use App\Models\Usuario;
use DB;

class MenthorCtrl extends Controller
{
	use UserTrait;
	public function index($page){
		$QT_PAGE = 15;
		$PAGE = $page;
		$TOTAL = DB::table('mentor')
								->join('usuario', 'mentor.usuario_id', '=', 'usuario.id')
								->where('usuario.activo', '=', 1)
								->count();
		$TOTAL_PAGES = ceil($TOTAL / $QT_PAGE);
		$dbMentors = DB::table('mentor')
									->join('usuario', 'mentor.usuario_id', '=', 'usuario.id')
									->where('usuario.activo', '=', 1)
									->skip(($PAGE - 1) * $QT_PAGE)
									->take($QT_PAGE)
									->get();
		$mentors = [];
		$res = (object) null;
        try{
            foreach ($dbMentors as $mentor) {
              $mentors[] = UserTrait::userData($mentor->usuario_id);
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
	public function indexAdmin($page){
		$QT_PAGE = 25;
		$PAGE = $page;
		$TOTAL = DB::table('mentor')
								->join('usuario', 'mentor.usuario_id', '=', 'usuario.id')
								->count();
		$TOTAL_PAGES = ceil($TOTAL / $QT_PAGE);
		$dbMentors = DB::table('mentor')
									->join('usuario', 'mentor.usuario_id', '=', 'usuario.id')
									->skip( ($PAGE - 1) * $QT_PAGE )
									->take($QT_PAGE)
									->get();
		$mentors = [];
		$res = (object) null;
		try{
				foreach ($dbMentors as $mentor) {
					$mentors[] = UserTrait::userData($mentor->usuario_id);
				}
				$res->success = true;
				$res->mentors = $mentors;
				$res->pages = $TOTAL_PAGES;
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
