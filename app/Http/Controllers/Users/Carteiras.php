<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Users\Carteira;

class Carteiras extends Controller
{

    public function index()
    {
        $carteira = Carteira::select('id','name')->orderBy('name')->get();

        return json_encode($carteira);
    }

}
