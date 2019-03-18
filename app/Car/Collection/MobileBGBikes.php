<?php

namespace App\Car\Collection;

use App\Car as Bike;
use Illuminate\Support\Collection;

class MobileBGBikes extends Base {

    const IDENTIFIER = 'MobileBGBikes';

    /** @var Collection $topOfferBikes */
    private $topOfferBikes;

    /** @var Collection $normalBikes */
    private $normalBikes;

    private $seenTopOfferBike = false;

    private $seenNormalBike = false;

    /** @var string $slink */
    private $slink = '';

    public function __construct() {
        parent::__construct();
        $this->normalBikes = collect();
        $this->topOfferBikes = collect();
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

    public function addCars(Collection $buses) {
        /** @var Bike $bike */
        foreach ($buses as $bike) {
            if ($bike->isTopOffer && $this->topOfferBikes->count() != self::INITIAL_CAR_LIMIT) {
                $this->topOfferBikes->push($bike);
                $this->cars->push($bike);
            } else if(!$bike->isTopOffer && $this->normalBikes->count() != self::INITIAL_CAR_LIMIT) {
                $this->normalBikes->push($bike);
                $this->cars->push($bike);
            }

            if ($this->normalBikes->count() >= self::INITIAL_CAR_LIMIT) {
                break;
            }
        }
    }

    public function addNewCars(Collection $seenBikes, Collection $newBikes) {
        /** @var Bike $newCar */
        foreach ($newBikes as $newBike) {
            if ($seenBikes->contains($newBike->link)) {
                if ($newBike->isTopOffer) {
                    $this->seenTopOfferBike = true;
                    continue;
                } else {
                    $this->seenNormalBike = true;
                    break;
                }
            } else {
                if ($newBike->isTopOffer && $this->seenTopOfferBike) {
                    continue;
                }
                $this->cars->push($newBike);
            }
        }
    }

    public function initialLimitReached() : bool {
        return $this->normalBikes->count() >= self::INITIAL_CAR_LIMIT;
    }

    public function seenPreviousCars() : bool {
        if ($this->seenNormalBike) {
            return true;
        }

        return false;
    }

}