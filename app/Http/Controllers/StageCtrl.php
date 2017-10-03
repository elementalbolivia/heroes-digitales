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
}
