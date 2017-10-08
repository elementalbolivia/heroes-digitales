<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TamanoPolera;

class ShirtCtrl extends Controller
{
  public function index(){
    $shirts = [];
    foreach (TamanoPolera::all() as $shirt) {
      $shirts[] = [
        'id'	=> $shirt->id,
        'label' => $shirt->nombre,
      ];
    }
    return response()->json([
      'success' => true,
      'shirts'	=> $shirts
    ]);
  }
}
