<?php

namespace App\Car\Collection;

use Illuminate\Support\Collection;

abstract class Base {

    const IDENTIFIER = null;

    const INITIAL_CAR_LIMIT = 10;

    /** @var Collection $cars */
    protected $cars;

    public function __construct() {
        $this->cars = collect();
    }

    /**
     * Used to add the initial cars
     * @param Collection $cars
     */
    abstract public function addCars(Collection $cars);

    abstract public function addNewCars(Collection $seenCars, Collection $newCars);

    abstract public function initialLimitReached() : bool;

    public function getCars() {
        return $this->cars;
    }

    /** @var array $searchParams */
    private $searchParams = [];

    public function setSearchParams(array $searchParams) {
        $this->searchParams = $searchParams;
    }

    public function getSearchParams() {
        return $this->searchParams;
    }

    abstract public function seenPreviousCars() : bool;
}