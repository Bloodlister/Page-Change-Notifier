<?php

namespace App\Car\Retriever;

use App\Helpers\FactoryBase;

class Factory extends FactoryBase {
    protected static $map = [
        MobileBG::IDENTIFIER => MobileBG::class,
        MobileBGBikes::IDENTIFIER => MobileBGBikes::class,
        CarsBg::IDENTIFIER => CarsBg::class,
    ];
}