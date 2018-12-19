<?php

namespace App\CarRetriever;

use App\CarCollection\CollectionBase;
use Illuminate\Support\Collection;

interface IRetriever {
    public function getCars(CollectionBase $collection, int $page = 1) : Collection;
}