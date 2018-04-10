<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Traits\UserTrait;
use App\Traits\ExpertTrait;
use App\Models\ExpertoEvaluaEquipo;
use DB;


class ExpertCtrl extends Controller
{
  use ExpertTrait;
  use UserTrait;
	public function index(){
		$experts = [];
        $res = (object) null;
        $expertsQuery = DB::table('usuario')
                      ->join('experto', 'usuario.id', '=', 'experto.usuario_id')
                      ->where('usuario.activo', '=', 1)
                      ->select('usuario.id')
                      ->get();
        $epxerts = [];
        try{
            foreach ($expertsQuery as $expert) {
              $experts[] = UserTrait::userData($expert->id);
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
  public function expertAssign(){
    $res = (object) null;
    DB::beginTransaction();
    try{
      $assigment = ExpertTrait::assignRandomTeams();
      ExpertoEvaluaEquipo::insert($assigment);
      $res->success = true;
      $res->msg = 'Equipos asignados exitosamente a los expertos';
      DB::commit();
      return response()->json($res);
    }catch(\Exception $e){
      $res->success = false;
      $res->msg = 'Hubo un error al hacer la selección de equipos';
      $res->err = $e->getMessage();
      DB::rollBack();
      return response()->json($res);
    }
  }
  public function assignToTeam(Request $request){
    $res = (object) null;
    try{
      $isTeamWithExpert = DB::table('experto_evalua_equipo')
                          ->where('equipo_id', '=', $request->teamId)
                          ->count();
      if($isTeamWithExpert >= 2){
        $res->success = false;
        $res->msg = 'El equipo tiene asignados 2 expertos';
        return response()->json($res);
      }
      $data = [
        'equipo_id'  => $request->teamId,
        'experto_id' => $request->expertId,
      ];
      ExpertoEvaluaEquipo::create($data);
      $res->msg = 'Experto asignado a equipo';
      $res->success = true;
    }catch(\Exception $e){
      $res->msg = 'Hubo un error al asignar al experto';
      $res->success = false;
      $res->err = $e->getMessage();
    }finally{
      return response()->json($res);
    }
  }
}
