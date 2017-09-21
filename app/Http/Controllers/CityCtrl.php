<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ciudad;

class CityCtrl extends Controller
{
    public function index(){
    	$cities = [];
    	foreach (Ciudad::all() as $city) {
    		$cities[] = [
    			'id'	=> $city->id,
    			'label' => $city->nombre
    		];
    	}
    	return response()->json([
    		'success' => true, 
    		'cities'	=> $cities
    	]);
    }
}
