<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zona;

class ZoneCtrl extends Controller
{
    public function index(){
    	$zones = [];
    	foreach (Zona::all() as $zone) {
    		$zones[] = [
    			'id'	=> $zone->id,
    			'label' => $zone->nombre,
    		];
    	}
    	return response()->json([
    		'success' => true, 
    		'zones'	=> $zones
    	]);
    }
}
