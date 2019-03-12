<?php

namespace App\Car\Collection;

use Illuminate\Support\Collection;

class CarsBG extends Base {

    public const IDENTIFIER = 'CarsBg';

    private $seenOldCar = false;

    public function addCars(Collection $cars) {
        foreach ($cars as $car) {
            $this->cars->push($car);
        }
    }

    public function addNewCars(Collection $seenCars, Collection $newCars) {
        foreach ($newCars as $newCar) {
            if ($seenCars->contains($newCar->link)) {
                $this->seenOldCar = true;
                break;
            }

            $this->cars->push($newCar);
        }
    }

    public function initialLimitReached() : bool {
        return $this->cars->count() >= self::INITIAL_CAR_LIMIT;
    }

    public function seenPreviousCars() : bool {
        return $this->seenOldCar;
    }
}