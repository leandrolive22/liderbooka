<?php

namespace App\Http\Controllers\Materiais;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Materiais\Filtro;
use App\Materiais\Material;
use App\Materiais\Tag;
use App\Materiais\Tipo;

class MaterialController extends Controller
{
    public function index()
    {
    	return view('wiki.wiki');
    }

	public function manager()
    {
    	$tipos = Tipo::all();
    	$tags = Tag::all();
    	return view('wiki.manager', compact('tipos'));
    }    
}
