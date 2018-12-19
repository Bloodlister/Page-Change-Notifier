<?php

namespace App\CarCollection;

use Illuminate\Support\Collection;

abstract class CollectionBase {

    const IDENTIFIER = null;

    protected $cars;

    public function __construct() {
        $this->cars = collect();
    }

    abstract public function addCars(Collection $cars);

    /** @var array $searchParams */
    private $searchParams = [];

    public function setSearchParams(array $searchParams) {
        $this->searchParams = $searchParams;
    }

    public function getSearchParams() {
        return $this->searchParams;
    }
}