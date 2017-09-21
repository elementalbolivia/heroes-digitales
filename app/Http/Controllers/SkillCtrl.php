<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Habilidad;
class SkillCtrl extends Controller
{
    public function index(){
    	$skills = [];
    	foreach (Habilidad::all() as $skill) {
    		$skills[] = [
    			'id'	=> $skill->id,
    			'label' => $skill->nombre
    		];
    	}
    	return response()->json([
    		'success' 	=> true, 
    		'skills'	=> $skills
    	]);
    }
}
