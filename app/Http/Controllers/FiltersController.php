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
        return response()->json(
            Filter::where('user_id', '=', $request->user()->id)
                ->get()
                ->map(function ($filter) {
                    /** @var Filter $filter */
                    return $filter->toArray();
                })
        );
    }

    public function create(Request $request) {
        $error = '';
        try {
            $filter = new Filter();
            $filter->type = $request->post('type');
            $filter->user_id = $request->user()->id;
            $filter->search_params = $request->post('data');
            $filter->save();
        } catch (\Exception $exception) {
            $error = $exception->getMessage();
        }
        return response()->json(
            ['success' => true, 'error' => $error],
            200,
            ['Content-type' => 'application/json'],
            JSON_UNESCAPED_UNICODE
        );
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
