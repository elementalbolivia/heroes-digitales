<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Division;

class DivisionCtrl extends Controller
{
    public function index(){
    	$divisions = [];
    	foreach (Division::all() as $division) {
    		$divisions[] = [
    			'id'	=> $division->id,
    			'label'	=> $division->nombre,
    			'desc'	=> $division->descripcion,
    		];
    	}
    	return response()->json(['success' => true, 'divisions'  => $divisions]);
    }
}
