<?php

namespace App\Helpers;

abstract class FactoryBase {

    protected static $map = [];

    public static function get($identifier, $params = []) {
        $mapObj = static::$map[$identifier];
        if (!$mapObj) {
            throw new \Exception('Undefined identifier "' . $identifier , '" for Factory:' . static::class);
        }

        return new $mapObj(...$params);
    }

}