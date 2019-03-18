<?php

namespace App\Car\Collection;

use App\Helpers\FactoryBase;

class Factory extends FactoryBase {
    protected static $map = [
        MobileBG::IDENTIFIER      => MobileBG::class,
        MobileBGBikes::IDENTIFIER => MobileBGBikes::class,
        MobileBGBuses::IDENTIFIER => MobileBGBuses::class,
        CarsBG::IDENTIFIER        => CarsBG::class,
        CarsBGBuses::IDENTIFIER   => CarsBGBuses::class,
    ];

    /**
     * @param       $identifier
     * @param array $params
     * @return Base
     * @throws \Exception
     */
    public static function get($identifier, $params = []) {
        return parent::get($identifier, $params);
    }
}