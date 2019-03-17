<?php

namespace App\Car\Retriever;

use App\Helpers\FactoryBase;

class Factory extends FactoryBase {
    protected static $map = [
        MobileBG::IDENTIFIER => MobileBG::class,
        MobileBGBikes::IDENTIFIER => MobileBGBikes::class,
        MobileBGBuses::IDENTIFIER => MobileBGBuses::class,
        CarsBg::IDENTIFIER => CarsBg::class,
    ];
}