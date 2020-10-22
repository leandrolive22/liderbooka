<?php

namespace App\Http\Controllers\Materiais;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mateirais\Material;
use App\Mateirais\Tag;
use App\Mateirais\Filtro;

class MaterialController extends Controller
{
    public function index()
    {
    	return view('wiki.wiki');
    }
}
