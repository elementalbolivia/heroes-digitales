<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profesion;

class ProfessionCtrl extends Controller
{
    public function index(){
    	$professions = [];
    	foreach (Profesion::all() as $profession) {
    		$professions[] = [
    			'id'	=> $profession->id,
    			'label' => $profession->nombre,
    		];
    	}
    	return response()->json([
    		'success' => true, 
    		'professions'	=> $professions
    	]);
    }
}
