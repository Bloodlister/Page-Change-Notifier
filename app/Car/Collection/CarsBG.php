<?php

namespace App\Car\Collection;

use Illuminate\Support\Collection;

class CarsBG extends Base {

    public const IDENTIFIER = 'CarsBG';

    /**
     * Used to add the initial cars
     * @param Collection $cars
     * @return mixed
     */
    public function addCars(Collection $cars) {
        // TODO: Implement addCars() method.
    }

    public function addNewCars(Collection $seenCars, Collection $newCars) {
        // TODO: Implement addNewCars() method.
    }

    public function initialLimitReached() : bool {
        // TODO: Implement initialLimitReached() method.
    }

    public function seenPreviousCars() : bool {
        // TODO: Implement seenPreviousCars() method.
    }
}