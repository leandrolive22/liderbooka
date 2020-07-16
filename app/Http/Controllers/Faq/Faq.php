<?php

namespace App\Http\Controllers\Faq;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class Faq extends Controller
{
    public function index() {
        $title = 'Faq';
        return view('faq.index', compact('title'));
    }

}
