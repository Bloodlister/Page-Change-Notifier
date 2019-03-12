<?php

namespace App\Http\Controllers;

use App\Car\Retriever\CarsBg;
use Illuminate\Http\Request;

class CarsBgController extends Controller {

    public function getModels(Request $request) {
        $brandId = $request->input('brandId');
        return response()->json(['models' => CarsBg::getModels($brandId)]);
    }

}