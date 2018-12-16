<?php

namespace App\CarValidator;

use App\Filter;
use Illuminate\Support\Collection;

abstract class Validator {

    const IDENTIFIER = null;

    abstract function collectionContainsSeenCar(Filter $filter, Collection $collection) : bool;

}