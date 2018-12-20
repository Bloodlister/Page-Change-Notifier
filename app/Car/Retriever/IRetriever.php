<?php

namespace App\Car\Retriever;

use App\Car\Collection\Base;
use Illuminate\Support\Collection;

interface IRetriever {
    public function getCars(Base $collection, int $page = 1) : Collection;

    public function getNewCars(Collection $seenCars, Base $collection, int $page = 1) : Collection;
}