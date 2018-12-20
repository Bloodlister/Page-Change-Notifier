<?php

namespace App\Car\Validator;

use App\Filter;
use Illuminate\Support\Collection;

class MobileBG extends Validator {

    public const IDENTIFIER = 1;

    function collectionContainsSeenCar(Filter $filter, Collection $collection) : bool {
        $seenCars = $filter->seenCars();
        foreach ($seenCars as $car) {
            if ($collection->contains($car->link)) {
                return true;
            }
        }
        return false;
    }
}