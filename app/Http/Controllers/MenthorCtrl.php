<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\UserTrait;
use App\Models\Usuario;
use DB;
use Excel;

class MenthorCtrl extends Controller
{
	use UserTrait;
	public function index(Request $request, $page){
		$QT_PAGE = 15;
		$PAGE = $page;
		$query = $this->queryReq($request, $PAGE, $QT_PAGE);
		$dbMentors = $query->rows;
		$TOTAL = $query->total;
		$TOTAL_PAGES = ceil($TOTAL / $QT_PAGE);
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
            $res->msg = 'Hubo un error al cargar los datos de los estudiantes';
            return response()->json($res);
        }
	}
	public function indexAdmin($page){
		// $QT_PAGE = 25;
		// $PAGE = $page;
		// $TOTAL = DB::table('mentor')
		// 						->join('usuario', 'mentor.usuario_id', '=', 'usuario.id')
		// 						->count();
		// $TOTAL_PAGES = ceil($TOTAL / $QT_PAGE);
		$dbMentors = DB::table('mentor')
									->join('usuario', 'mentor.usuario_id', '=', 'usuario.id')
									// ->skip( ($PAGE - 1) * $QT_PAGE )
									// ->take($QT_PAGE)
									->get();
		$mentors = [];
		$res = (object) null;
		try{
				foreach ($dbMentors as $mentor) {
					$mentors[] = UserTrait::userData($mentor->usuario_id);
				}
				$res->success = true;
				$res->mentors = $mentors;
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
		private function queryReq($request, $page, $quantityPerPage = 15){
			$match = (object) null;
			$QT_PAGE = $quantityPerPage;
			$PAGE = $page;
			$cities = json_decode($request->city);
			$mentorName = $request->mentorName;
			$withTeam = $request->withTeam == "true" ? true : false;
			if($mentorName != "" || isset($mentorName)){
				$match->rows = DB::table('usuario')
							 ->join('mentor', function($join){
								 $join->on('usuario.id', '=', 'mentor.usuario_id');
							 })
							 ->where('usuario.activo', '=', 1)
							 ->where('usuario.nombres', 'like', '%'. $mentorName .'%')
							 ->orWhere('usuario.apellidos', 'like', '%'.$mentorName.'%')
							 ->skip(($PAGE - 1) * $QT_PAGE)
							 ->take($QT_PAGE)
							 ->get();
				 $match->total =  DB::table('usuario')
							 ->join('mentor', function($join){
								 $join->on('usuario.id', '=', 'mentor.usuario_id');
							 })
							 ->where('usuario.activo', '=', 1)
							 ->where('usuario.nombres', 'like', '%'. $mentorName .'%')
							 ->orWhere('usuario.apellidos', 'like', '%'.$mentorName.'%')
							 ->count();
				 return $match;
			}
			if(count($cities) > 0 )
				if($cities[0] == "")
					unset($cities[0]);
			if(count($cities) != 0 && $withTeam){
				 $match->rows = DB::table('usuario')
								->join('mentor', function($join) use ($cities) {
									$join->on('usuario.id', '=', 'mentor.usuario_id');
								})
								->join('estudiante_mentor_tiene_equipo', function($join){
									$join->on('mentor.id', '=', 'estudiante_mentor_tiene_equipo.mentor_id');
								})
								->where([
									'estudiante_mentor_tiene_equipo.aprobado' => 1,
									'estudiante_mentor_tiene_equipo.activo'		=> 1
								])
								->whereIn('ciudad_id', $cities)
								->where('usuario.activo', '=', 1)
								->skip(($PAGE - 1) * $QT_PAGE)
								->take($QT_PAGE)
								->get();
					$match->total =  DB::table('usuario')
								->join('mentor', function($join) use ($cities) {
									$join->on('usuario.id', '=', 'mentor.usuario_id');
								})
								->join('estudiante_mentor_tiene_equipo', function($join){
									$join->on('mentor.id', '=', 'estudiante_mentor_tiene_equipo.mentor_id');
								})
								->where([
									'estudiante_mentor_tiene_equipo.aprobado' => 1,
									'estudiante_mentor_tiene_equipo.activo'		=> 1
								])
								->where('usuario.activo', '=', 1)
								->whereIn('ciudad_id', $cities)
 								->count();
			}else if(count($cities) != 0 && !$withTeam){
				$match->rows = DB::table('usuario')
									->join('mentor', function($join) use ($cities){
										$join->on('usuario.id', '=', 'mentor.usuario_id');
									})
									->leftJoin('estudiante_mentor_tiene_equipo', function($join){
										$join->on('mentor.id', '=', 'estudiante_mentor_tiene_equipo.mentor_id');
								})
								->where('usuario.activo', '=', 1)
								->whereIn('usuario.ciudad_id', $cities)
								->whereNull('estudiante_mentor_tiene_equipo.mentor_id')
								->skip(($PAGE - 1) * $QT_PAGE)
								->take($QT_PAGE)
								->get();
				$match->total = DB::table('usuario')
									->join('mentor', function($join) use ($cities){
										$join->on('usuario.id', '=', 'mentor.usuario_id');
									})
									->leftJoin('estudiante_mentor_tiene_equipo', function($join){
										$join->on('mentor.id', '=', 'estudiante_mentor_tiene_equipo.mentor_id');
								})
								->where('usuario.activo', '=', 1)
								->whereIn('usuario.ciudad_id', $cities)
								->whereNull('estudiante_mentor_tiene_equipo.mentor_id')
								->count();
			}else if(count($cities) == 0){
				if(!$withTeam){
					$match->rows = DB::table('usuario')
									->join('mentor', function($join){
										$join->on('usuario.id', '=', 'mentor.usuario_id');
									})
										->leftJoin('estudiante_mentor_tiene_equipo', function($join){
											$join->on('mentor.id', '=', 'estudiante_mentor_tiene_equipo.mentor_id');
									})
									->where('usuario.activo', '=', 1)
									->whereNull('estudiante_mentor_tiene_equipo.mentor_id')
									->skip(($PAGE - 1) * $QT_PAGE)
									->take($QT_PAGE)
									->get();
					$match->total = DB::table('usuario')
										->join('mentor', function($join){
											$join->on('usuario.id', '=', 'mentor.usuario_id');
										})
										->leftJoin('estudiante_mentor_tiene_equipo', function($join){
											$join->on('mentor.id', '=', 'estudiante_mentor_tiene_equipo.mentor_id');
									})
									->where('usuario.activo', '=', 1)
									->whereNull('estudiante_mentor_tiene_equipo.mentor_id')
									->count();
				}else{
					$match->rows = DB::table('usuario')
								->join('mentor', function($join){
									$join->on('usuario.id', '=', 'mentor.usuario_id');
								})
 								->join('estudiante_mentor_tiene_equipo', function($join){
 									$join->on('mentor.id', '=', 'estudiante_mentor_tiene_equipo.mentor_id');
 								})
								->where('usuario.activo', '=', 1)
 								->where([
 									'estudiante_mentor_tiene_equipo.aprobado' => 1,
 									'estudiante_mentor_tiene_equipo.activo'		=> 1
 								])
 								->skip(($PAGE - 1) * $QT_PAGE)
 								->take($QT_PAGE)
 								->get();
 					$match->total =  DB::table('usuario')
								->join('mentor', function($join){
									$join->on('usuario.id', '=', 'mentor.usuario_id');
								})
 								->join('estudiante_mentor_tiene_equipo', function($join){
 									$join->on('mentor.id', '=', 'estudiante_mentor_tiene_equipo.mentor_id');
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
				$NAME = date('Y-m-d') . '-mentores';
				$dbMentors = DB::table('mentor')
											->join('usuario', 'mentor.usuario_id', '=', 'usuario.id')
											->get();
				$mentors = [];
				foreach ($dbMentors as $mentor) {
					$mentors[] = UserTrait::userData($mentor->usuario_id);
				}
				Excel::create($NAME, function($excel) use($mentors){
					$excel->sheet('Mentores', function($sheet) use($mentors){
						$sheet->loadView('excel_reports.mentors', ['mentors' => $mentors]);
					});
				})->download('xls');
				$res->success = true;
				$res->msg = 'Descargando...';
			}catch(\Exception $e){
				$res->success = false;
				$res->msg = 'Hubo un error al descargar y generar el reporte';
				$res->err = $e->getMessage();
			}finally{
				return response()->json($res);
			}
		}
}
