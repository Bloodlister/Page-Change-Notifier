<?php

namespace App\Car\Retriever;

use App\Helpers\FactoryBase;

class Factory extends FactoryBase {
    protected static $map = [
        MobileBG::IDENTIFIER => MobileBG::class,
    ];
}