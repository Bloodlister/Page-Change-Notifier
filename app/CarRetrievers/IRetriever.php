<?php

namespace App\CarRetriever;

use Illuminate\Support\Collection;

interface IRetriever {
    public function getCars(array $searchParams, int $page = 1) : Collection;
}