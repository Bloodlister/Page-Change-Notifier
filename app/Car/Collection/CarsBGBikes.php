<?php

namespace App\Car\Collection;

use Illuminate\Support\Collection;

class CarsBGBikes extends Base {

    public const IDENTIFIER = 'CarsBgBikes';

    private $seenOldBike = false;

    public function addCars(Collection $bikes) {
        foreach ($bikes as $bike) {
            $this->cars->push($bike);
        }
    }

    public function addNewCars(Collection $seenBikes, Collection $newBikes) {
        foreach ($newBikes as $newBike) {
            if ($seenBikes->contains($newBike->link)) {
                $this->seenOldBike = true;
                break;
            }

            $this->cars->push($newBike);
        }
    }

    public function initialLimitReached() : bool {
        return $this->cars->count() >= self::INITIAL_CAR_LIMIT;
    }

    public function seenPreviousCars() : bool {
        return $this->seenOldBike;
    }
}