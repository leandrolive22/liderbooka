<?php

namespace App\Http\Controllers\Materials;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
USE Illuminate\Support\Facades\Auth;
use App\Materials\SubLocal;

class SubLocais extends Controller
{
    public function index()
    {
        $sublocais = SubLocal::all();
        return $sublocais->toJSON();
    }

    public function byIlha($ilha, $select = '*', $json = TRUE) {
        $sublocais = SubLocal::selectRaw($select)->where('ilha_id',$ilha)->get();
        if($sublocais->count() == 0) {
            return 0;
        }

        if($json == TRUE) {
            return $sublocais->toJSON();    
        }

        return $sublocais;
        
    }

    public function byid($id) {
        $sublocais = SubLocal::find($id);
        return $sublocais->toJSON();
    }

    public function pdf() {
        $title = 'Pdf';
        return view('wiki.pdf', compact('title'));
    }

}
