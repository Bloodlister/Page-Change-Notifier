<?php

namespace App\Car\Validator;

use App\Helpers\FactoryBase;

class Factory extends FactoryBase {

    protected static $map = [
        MobileBG::IDENTIFIER => MobileBG::class,

    ];

    /**
     * @param       $identifier
     * @param array $params
     * @return Validator
     * @throws \Exception
     */
    public static function get($identifier, $params = []) {
        return parent::get($identifier, $params);
    }
}
