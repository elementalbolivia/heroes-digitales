<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etapa;

class StageCtrl extends Controller
{
  public function index(){
    $stages = [];
    foreach (Etapa::all() as $stage) {
      $stages[] = [
        'id'	=> $stage->id,
        'label' => $stage->nombre,
        'desc'  => $stage->descripcion,
        'begin_date' => $stage->fecha_inicio,
        'end_date' => $stage->fecha_fin,
        'active'  => $stage->activo == 1 ? true : false,
      ];
    }
    return response()->json([
      'success' 	=> true,
      'stages'	=> $stages
    ]);
  }
  public function create(Request $request){
    $res = (object) null;
    try{
      $stage = [
        'nombre'  => $request->name,
        'descripcion' => $request->desc,
        'fecha_inicio'  =>$request->beginDate,
        'fecha_fin'  => $request->endDate
      ];
      $newStage = Etapa::create($stage);
      $res->success = true;
      $res->stageId = $newStage->id;
      return response()->json($res);
    }catch(\Exception $e){
      $res->success = false;
      $res->msg = 'Se produjo un error al crear la etapa, inténtelo nuevamente';
      return response()->json($res);
    }
  }
  public function getStage($stageId){
    $res = (object) null;
    $stage = Etapa::find($stageId);
    $res->stage = [
        'id'          => $stage->id,
        'name'      => $stage->nombre,
        'desc' => $stage->descripcion,
        'begin_date'=> $stage->fecha_inicio,
        'end_date'   => $stage->fecha_fin
    ];
    $res->success = true;
    return response()->json($res);
  }
}
