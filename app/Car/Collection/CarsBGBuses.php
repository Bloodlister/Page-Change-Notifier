<?php

namespace App\Car\Collection;

use Illuminate\Support\Collection;

class CarsBGBuses extends Base {

    public const IDENTIFIER = 'CarsBgBuses';

    private $seenOldBus = false;

    public function addCars(Collection $buses) {
        foreach ($buses as $bus) {
            $this->cars->push($bus);
        }
    }

    public function addNewCars(Collection $seenBuses, Collection $newBuses) {
        foreach ($newBuses as $newBus) {
            if ($seenBuses->contains($newBus->link)) {
                $this->seenOldBus = true;
                break;
            }

            $this->cars->push($newBus);
        }
    }

    public function initialLimitReached() : bool {
        return $this->cars->count() >= self::INITIAL_CAR_LIMIT;
    }

    public function seenPreviousCars() : bool {
        return $this->seenOldBus;
    }
}