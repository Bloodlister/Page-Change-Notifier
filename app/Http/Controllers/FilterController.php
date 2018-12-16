<?php

namespace App\Http\Controllers;

use App\Filter;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function filterForm() {
        return view('filters.vue');
    }

    public function createFilter(Request $request) {
        $filter = new Filter($request->all());
        $filter->save();
    }
}
