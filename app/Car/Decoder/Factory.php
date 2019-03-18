<?php

namespace App\Car\Decoder;

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
     * @return Decoder
     * @throws \Exception
     */
    public static function get($identifier, $params = []) {
        return parent::get($identifier, $params);
    }
}