<?php

namespace App\Car\Collection;

use App\Car as Bus;
use Illuminate\Support\Collection;

class MobileBGBuses extends Base {

    const IDENTIFIER = 'MobileBGBuses';

    /** @var Collection $topOfferBuses */
    private $topOfferBuses;

    /** @var Collection $normalBuses */
    private $normalBuses;

    private $seenTopOfferBus = false;

    private $seenNormalBus = false;

    /** @var string $slink */
    private $slink = '';

    public function __construct() {
        parent::__construct();
        $this->normalBuses = collect();
        $this->topOfferBuses = collect();
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
        /** @var Bus $bus */
        foreach ($buses as $bus) {
            if ($bus->isTopOffer && $this->topOfferBuses->count() != self::INITIAL_CAR_LIMIT) {
                $this->topOfferBuses->push($bus);
                $this->cars->push($bus);
            } else if(!$bus->isTopOffer && $this->normalBuses->count() != self::INITIAL_CAR_LIMIT) {
                $this->normalBuses->push($bus);
                $this->cars->push($bus);
            }

            if ($this->normalBuses->count() >= self::INITIAL_CAR_LIMIT) {
                break;
            }
        }
    }

    public function addNewCars(Collection $seenBuses, Collection $newBuses) {
        /** @var Bus $newBus */
        foreach ($newBuses as $newBus) {
            if ($seenBuses->contains($newBus->link)) {
                if ($newBus->isTopOffer) {
                    $this->seenTopOfferBus = true;
                    continue;
                } else {
                    $this->seenNormalBus = true;
                    break;
                }
            } else {
                if ($newBus->isTopOffer && $this->seenTopOfferBus) {
                    continue;
                }
                $this->cars->push($newBus);
            }
        }
    }

    public function initialLimitReached() : bool {
        return $this->normalBuses->count() >= self::INITIAL_CAR_LIMIT;
    }

    public function seenPreviousCars() : bool {
        if ($this->seenNormalBus) {
            return true;
        }

        return false;
    }

}