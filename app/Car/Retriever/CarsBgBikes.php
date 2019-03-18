<?php

namespace App\Car\Retriever;

use App\Helpers\Request;
use App\Car\Collection\Base;
use Illuminate\Support\Collection;

class CarsBgBikes extends Retriever {

    public const IDENTIFIER = 'CarsBgBikes';

    public static function getModels(int $brandId) {
        $response = Request::sendGetRequest('https://www.cars.bg/?ajax=multimodel&brandId=' . $brandId);
        $response = trim(explode('<script>', $response)[0]);
        $response = preg_replace('/<div>.*<\/div>/', '', $response);
        $response = preg_replace('/<p.*>[\s\S]*<\/p>/m', '', $response);
        $response = trim($response);

        return \App\Car\Decoder\CarsBG::getModels($response);
    }

    public function getCars(Base $collection, int $page = 1) : Collection {
        $query = 'https://www.cars.bg/?go=moto&search=1&filterOrderBy=1&section=moto&' .
            'page=' . $page . '&' .
            http_build_query($collection->getSearchParams());
        
        $response = Request::sendGetRequest($query);
        $decoder = \App\Car\Decoder\Factory::get(\App\Car\Decoder\CarsBG::IDENTIFIER);

        $bikes = $decoder->getCars($response);

        if ($bikes->count() > 0) {
            $collection->addCars($bikes);
        }

        if ($bikes->count() == 0 || $collection->initialLimitReached()) {
            return $collection->getCars();
        } else {
            $page += 1;
            return $this->getCars($collection, $page);
        }
    }

    public function getNewCars(Collection $seenBikes, Base $collection, int $page = 1) : Collection {
        $query = 'https://www.cars.bg/?go=moto&search=1&filterOrderBy=1&section=moto&' .
            'page=' . $page . '&' .
            http_build_query($collection->getSearchParams());

        $response = Request::sendGetRequest($query);
        $decoder = \App\Car\Decoder\Factory::get(\App\Car\Decoder\CarsBG::IDENTIFIER);

        $bikes = $decoder->getCars($response);

        if ($bikes->count() > 0) {
            $collection->addNewCars($seenBikes, $bikes);
        }

        if ($bikes->count() == 0 || $collection->seenPreviousCars()) {
            return $collection->getCars();
        } else {
            $page += 1;
            return $this->getNewCars($seenBikes, $collection, $page);
        }
    }
}
