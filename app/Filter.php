<?php

namespace App;

use App\CarRetriever\Factory;
use App\CarRetriever\IRetriever;
use App\CarValidator\MobileBG;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class Filter
 * @package App
 * @property $user_id
 * @property $type
 * @property $search_params
 */
class Filter extends Model
{
    protected $table = 'filters';

    public $timestamps = true;

    public $primaryKey = 'id';

    public $carValidationClass = MobileBG::class;

    public function user() {
        return $this->belongsTo(User::class, 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function seenCars() {
        return $this->hasMany(Car::class, 'filter_id');
    }

    protected static function boot() {
        parent::boot();

        self::created(function(Filter $model) {
            $model->initiateFilter();
        });
    }

    protected function initiateFilter() {
        $carRetriever = $this->getRetriever($this->type);
        $initialCars = $carRetriever->getCars($this->search_params);
        $this->seenCars()->saveMany($initialCars);
    }

    /**
     * @param $type
     * @return IRetriever
     * @throws \Exception
     */
    private function getRetriever($type) : IRetriever {
        return Factory::getRetriever($type);
    }

    public function seenCarInCollection(Collection $collection) : bool {
        $validator = \App\CarValidator\Factory::get($this->type);
        $validator->collectionContainsSeenCar($this, $collection);
    }

    public function getSeenCarLinks() : Collection {
        $carLinks = collect();
        $seenCars = $this->seenCars();
        foreach ($seenCars as $car) {
            $carLinks->push($car->link);
        }
        return $carLinks;
    }
}
