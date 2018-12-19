<?php

namespace App\CarCollection;

use Illuminate\Support\Collection;

class MobileBG extends CollectionBase {

    const IDENTIFIER = 'MobileBG';

    /** @var string $slink */
    private $slink = '';

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

    }

}