<?php

namespace App\CarRetriever;

use App\Filter;
use Illuminate\Support\Collection;

abstract class Retriever implements IRetriever {

    const IDENTIFIER = null;

    public function getNewCars(Filter $filter, array $searchParams) : Collection {
        $newCarCollection = collect();
        $page = 1;
        while (true) {
            $newCarCollection = $newCarCollection->concat($this->getCars($searchParams, $page));
            if ($newCarCollection->isEmpty()) {
                return $newCarCollection;
            } else {
                $page++;
                if ($filter->seenCarInCollection($newCarCollection)) {
                    return $newCarCollection;
                }
            }
        }
    }
}