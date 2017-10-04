<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checkpoint;
use App\Models\Pregunta;
use App\Models\CheckpointTienePregunta;

date_default_timezone_set('America/La_Paz');
class QuestionCtrl extends Controller
{
    //
    public function getQuestionsFromCheckpoint($checkId){
      $res = (object) null;
      try{
        $checkpoint = Checkpoint::find($checkId);
        $questions = [];
        foreach ($checkpoint->hasQuestions as $question) {
          $questions[] = [
            'id'         => $question->id,
            'question'      => $question->pregunta,
            'type'  => $question->tipo_pregunta_id == null ? 'Ninguno' : $question->typeQuestion($question->tipo_pregunta_id),
          ];
        }
        $res->success = true;
        $res->questions = $questions;
        return response()->json($res);
      }catch(\Exception $e){
        $res->success = false;
        $res->msg = 'Hubo un error al cargar las preguntas del checkpoint: ' . $e->getMessage();
        return response()->json($res);
      }
    }
    public function createQuestions(Request $request, $checkpointId){
      $res = (object) null;
      try{
        $checkpoint_questions = [];
        foreach($request->questions as $question){
          $newQuestion = Pregunta::create([
            'pregunta'  => $question['question'],
            'tipo_pregunta_id' => NULL,
          ]);
          $checkpoint_questions[] = [
            'pregunta_id'    => $newQuestion->id,
            'checkpoint_id'  => $checkpointId,
            'fecha_creacion'  => date('Y-m-d H:i:s'),
            'fecha_actualizacion'  => date('Y-m-d H:i:s'),
          ];
        }
        $newQuestions = CheckpointTienePregunta::insert($checkpoint_questions);
        $res->success = true;
        $res->msg = 'Las preguntas fueron creadas con éxito';
        return response()->json($res);
      }catch(\Exception $e){
        $res->success = false;
        $res->msg = 'Hubo un error al crear las nuevas preguntas, inténtelo nuevamente: ' . $e->getMessage();
        return response()->json($res);
      }
    }
}
