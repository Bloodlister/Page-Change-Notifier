<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Listenings extends Controller
{
    public function index() {
        return view('vue');
    }

    public function createFilter(Request $request) {
        $filter = new Filter($request->all());
        $filter->save();
        $filter->init();
    }
}
