<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colegio;

class SchoolCtrl extends Controller
{
    public function index(){
    	$schools = [];
    	foreach (Colegio::all() as $school) {
    		$schools[] = [
    			'id'	=> $school->id,
    			'label' => $school->nombre,
    		];
    	}
    	return response()->json([
    		'success' => true, 
    		'schools'	=> $schools
    	]);
    }
}
