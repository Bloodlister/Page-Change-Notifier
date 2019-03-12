<?php

namespace App\Car\Retriever;

use App\Car\Collection\Base;
use Illuminate\Support\Collection;

interface IRetriever {
    /**
     * Used to get the cars for the initiation of the filter
     *
     * @param Base $collection
     * @param int $page
     * @return Collection
     * @throws \Exception
     */
    public function getCars(Base $collection, int $page = 1) : Collection;


    /**
     * Used to get the new cars for the filter
     *
     * @param Collection $seenCars
     * @param Base       $collection
     * @param int        $page
     * @return Collection
     */
    public function getNewCars(Collection $seenCars, Base $collection, int $page = 1) : Collection;
}