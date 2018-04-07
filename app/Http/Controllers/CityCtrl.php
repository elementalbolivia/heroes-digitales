<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ciudad;

class CityCtrl extends Controller
{
    public function index(){
    	$cities = [];
      try{
        foreach (Ciudad::all() as $city) {
      		$cities[] = [
      			'id'	=> $city->id,
      			'label' => $city->nombre
      		];
      	}
      	return response()->json([
      		'success' => true,
      		'cities'	=> $cities,
          'msg'  => '200 OK',
      	]);
      }catch(\Exception $e){
        return response()->json([
      		'success' => false,
          'err'  => $e->getMessage(),
          'msg'  => 'Hubo un error en el servidor'
      	]);
      }
    }
}
