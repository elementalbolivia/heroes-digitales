<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etapa;
use App\Models\Checkpoint;

class CheckpointCtrl extends Controller
{
    public function getCheckPointsAtStage($stageId){
      $res = (object) null;
      try{
        $stage = Etapa::find($stageId);
        $checkpoints = [];
        foreach ($stage->hasCheckpoints as $checkpoint) {
          $checkpoints[] = [
            'id'         => $checkpoint->id,
            'label'      => $checkpoint->nombre,
            'eval_date'  => $checkpoint->fecha_evaluacion,
          ];
        }
        $res->success = true;
        $res->checkpoints = $checkpoints;
        return response()->json($res);
      }catch(\Exception $e){
        $res->success = false;
        $res->msg = 'Hubo un error al cargar los datos de los checkpoints';
        return response()->json($res);
      }
    }
    public function createCheckpoint(Request $request){
      $res = (object) null;
      try{
        $checkpoint = [
          'etapa_id'  => $request->stageId,
          'nombre'    => $request->name,
          'fecha_evaluacion' => $request->evalDate,
        ];
        $newCheckpoint = Checkpoint::create($checkpoint);
        $res->success = true;
        $res->checkId = $newCheckpoint->id;
        return response()->json($res);
      }catch(\Exception $e){
        $res->success = false;
        $res->msg = 'Hubo un error al crear el checkpoint, inténtelo nuevamente';
        return response()->json($res);
      }
    }
    public function getCheckpoint($stageId, $checkpointId){
      $res = (object) null;
      try{
        $checkpoint = Checkpoint::find($checkpointId);
        $checkpointData = [
          'id'         => $checkpoint->id,
          'label'      => $checkpoint->nombre,
          'eval_date'  => $checkpoint->fecha_evaluacion,
        ];
        $res->success = true;
        $res->checkpoint = $checkpointData;
        return response()->json($res);
      }catch(\Exception $e){
        $res->success = false;
        $res->msg = 'Hubo un error al cargar los datos del checkpoint: ' . $e->getMessage();
        return response()->json($res);
      }
    }
}
