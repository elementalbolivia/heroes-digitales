<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genero;

class GenreCtrl extends Controller
{
    public function index(){
    	$genres = [];
    	foreach (Genero::all() as $genre) {
    		$genres[] = [
    			'id'	=> $genre->id,
    			'label' => $genre->descripcion,
    		];
    	}
    	return response()->json([
    		'success' => true, 
    		'genres'	=> $genres
    	]);
    }
}
