<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Experticia;

class ExpertiseCtrl extends Controller
{
    public function index(){
    	$expertises = [];
    	foreach (Experticia::all() as $expertise) {
    		$expertises[] = [
    			'id'	=> $expertise->id,
    			'label'	=> $expertise->nombre,
    		];
    	}
    	return response()->json(['success' => true, 'expertises'  => $expertises]);
    }
}
