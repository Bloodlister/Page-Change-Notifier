<?php

namespace App\Car\Retriever;

use App\Car\Collection\Base;

use App\Helpers\Request;
use Illuminate\Support\Collection;

class CarsBg extends Retriever {

    public const IDENTIFIER = 'CarsBg';

    public static function getModels(int $brandId) {
        $response = Request::sendGetRequest('https://www.cars.bg/?ajax=multimodel&brandId=' . $brandId);
        $response = trim(explode('<script>', $response)[0]);
        $response = preg_replace('/<div>.*<\/div>/', '', $response);
        $response = preg_replace('/<p.*>[\s\S]*<\/p>/m', '', $response);
        $response = trim($response);

        return \App\Car\Decoder\CarsBG::getModels($response);
    }

    public function getCars(Base $collection, int $page = 1) : Collection {
        $query = 'https://www.cars.bg/?go=cars&search=1&filterOrderBy=1&section=cars&' .
            'page=' . $page . '&' .
            http_build_query($collection->getSearchParams());

        $response = Request::sendGetRequest($query);
        $decoder = \App\Car\Decoder\Factory::get(\App\Car\Decoder\CarsBG::IDENTIFIER);

        $cars = $decoder->getCars($response);

        if ($cars->count() > 0) {
            $collection->addCars($cars);
        }

        if ($cars->count() == 0 || $collection->initialLimitReached()) {
            return $collection->getCars();
        } else {
            $page += 1;
            return $this->getCars($collection, $page);
        }
    }

    public function getNewCars(Collection $seenCars, Base $collection, int $page = 1) : Collection {
        $query = 'https://www.cars.bg/?go=cars&search=1&filterOrderBy=1&section=cars&' .
            'page=' . $page . '&' .
            http_build_query($collection->getSearchParams());

        $response = Request::sendGetRequest($query);
        $decoder = \App\Car\Decoder\Factory::get(\App\Car\Decoder\CarsBG::IDENTIFIER);

        $cars = $decoder->getCars($response);

        if ($cars->count() > 0) {
            $collection->addNewCars($seenCars, $cars);
        }

        if ($cars->count() == 0 || $collection->seenPreviousCars()) {
            return $collection->getCars();
        } else {
            $page += 1;
            return $this->getNewCars($seenCars, $collection, $page);
        }
    }
}