<?php

namespace App\Car\Collection;

use App\Car;
use Illuminate\Support\Collection;

class MobileBG extends Base {

    const IDENTIFIER = 'MobileBG';

    const INITIAL_CAR_LIMIT = 10;

    /** @var Collection $topOfferCars */
    private $topOfferCars;

    /** @var Collection $normalCars */
    private $normalCars;

    private $seenTopOfferCar = false;

    private $seenNormalCar = false;

    /** @var string $slink */
    private $slink = '';

    public function __construct() {
        parent::__construct();
        $this->normalCars = collect();
        $this->topOfferCars = collect();
    }

    /**
     * @return string
     */
    public function getSlink() : string {
        return $this->slink;
    }

    /**
     * @param string $slink
     */
    public function setSlink(string $slink) : void {
        $this->slink = $slink;
    }

    public function addCars(Collection $cars) {
        /** @var Car $car */
        foreach ($cars as $car) {
            if ($car->isTopOffer && $this->topOfferCars->count() != self::INITIAL_CAR_LIMIT) {
                $this->topOfferCars->push($car);
                $this->cars->push($car);
            } else if(!$car->isTopOffer && $this->normalCars->count() != self::INITIAL_CAR_LIMIT) {
                $this->normalCars->push($car);
                $this->cars->push($car);
            }

            if ($this->normalCars->count() >= self::INITIAL_CAR_LIMIT) {
                break;
            }
        }
    }

    public function addNewCars(Collection $seenCars, Collection $newCars) {
        /** @var Car $newCar */
        foreach ($newCars as $newCar) {
            if ($seenCars->contains($newCars->link)) {
                if ($newCar->isTopOffer) {
                    $this->seenTopOfferCar = true;
                    continue;
                } else {
                    $this->seenNormalCar = true;
                    break;
                }
            } else {
                if ($newCar->isTopOffer && $this->seenTopOfferCar) {
                    continue;
                }
                $this->cars->push($newCar);
            }
        }
    }

    public function initialLimitReached() : bool {
        return $this->normalCars->count() >= self::INITIAL_CAR_LIMIT;
    }

    public function seenPreviousCars() : bool {
        if ($this->seenNormalCar) {
            return true;
        }

        return false;
    }

}