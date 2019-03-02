<?php

namespace App\Car\Retriever;

use App\Car\Collection\Base;

use App\Helpers\Request;
use Illuminate\Support\Collection;

class CarsBg extends Retriever {

    public const IDENTIFIER = 'CarsBG';

    public static function getModels(int $brandId) {
        $response = Request::sendGetRequest('https://www.cars.bg/?ajax=multimodel&brandId=' . $brandId);
        $response = trim(explode('<script>', $response)[0]);
        $response = preg_replace('/<div>.*<\/div>/', '', $response);
        $response = preg_replace('/<p.*>[\s\S]*<\/p>/m', '', $response);
        $response = trim($response);

        return \App\Car\Decoder\CarsBG::getModels($response);
    }

    public function getCars(Base $collection, int $page = 1) : Collection {

    }

    public function getNewCars(Collection $seenCars, Base $collection, int $page = 1) : Collection {

    }
}