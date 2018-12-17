<?php

namespace App\Http\Controllers;

use App\Filter;
use Illuminate\Http\Request;

class FiltersController extends Controller
{
    public function index() {
        return view('filters.vue');
    }

    public function all(Request $request) {
        return response()->json(Filter::where('user_id', '=', $request->user()->id)->get()->map(function ($filter) {
            return $filter->toArray();
        }));
    }

    public function create(Request $request) {
        $filter = new Filter($request->all());
        $filter->save();
    }

    public function delete(Request $request) {
        /** @var Filter $filter */
        $filter = Filter::where('id', '=', $request->post('filterId'))->first();
        if ($filter && $filter->user_id == $request->user()->id) {
            $filter->forceDelete();
            return response()->json(['success' => true]);
        }
    }

}
