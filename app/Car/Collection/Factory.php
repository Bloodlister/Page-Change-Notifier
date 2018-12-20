<?php

namespace App\Car\Collection;

use App\Helpers\FactoryBase;

class Factory extends FactoryBase {
    protected static $map = [
        MobileBG::IDENTIFIER => MobileBG::class,
    ];

    /** @return Base */
    public static function get($identifier, $params = []) {
        return parent::get($identifier, $params);
    }
}