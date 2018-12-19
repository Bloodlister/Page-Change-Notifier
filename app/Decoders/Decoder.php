<?php

namespace App\Decoders;

use App\Car;
use Illuminate\Support\Collection;

abstract class Decoder {
     const IDENTIFIER = null;

    abstract protected function getCarsHTMLFromPage(string $pageHTML) : Collection;

    abstract protected function getCarFromHTML(string $html) : Car;

    public function getCars($pageHTML) : Collection {
        $carsCollection = $this->getCarsHTMLFromPage($pageHTML);
        $cars = collect();
        foreach ($carsCollection as $carHTML) {
            $cars->push($this->getCarFromHTML($carHTML));
        }

        return $cars;
    }

}