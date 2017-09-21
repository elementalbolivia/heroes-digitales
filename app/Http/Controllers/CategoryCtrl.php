<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoryCtrl extends Controller
{
    public function index(){
    	$categories = [];
    	foreach (Categoria::all() as $category) {
    		$categories[] = [
    			'id'	=> $category->id,
    			'label'	=> $category->nombre,
    			'desc'	=> $category->descripcion,
    		];
    	}
        return response()->json(['success' => true, 'categories'  => $categories]);
    }
}
