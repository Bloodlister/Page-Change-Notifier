<?php

namespace App;

use App\Car\Collection\Factory as CollectionFactory;
use App\Car\Retriever\Factory;
use App\Car\Retriever\IRetriever;
use App\Car\Validator\MobileBG;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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

    protected $fillable = ['user_id', 'type', 'search_params'];

    protected static function boot() {
        parent::boot();

        self::created(function(Filter $model) {
            $model->initiateFilter();
        });
    }

    public function user() {
        return $this->belongsTo(User::class, 'id');
    }

    public function setSearchParamsAttribute($value) {
        $this->attributes['search_params'] = \json_encode($value);
    }

    public function getSearchParamsAttribute() {
        return json_decode($this->attributes['search_params'], true);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function seenCars() {
        return $this->hasMany(Car::class, 'filter_id');
    }

    protected function initiateFilter() {
        $carRetriever = $this->getRetriever($this->type);
        $searchParams = $this->search_params;

        $collection = CollectionFactory::get($this->type);
        $collection->setSearchParams($searchParams);
        $initialCars = $carRetriever->getCars($collection, 1);
        $this->seenCars()->saveMany($initialCars);
    }

    /**
     * @param $type
     * @return IRetriever
     * @throws \Exception
     */
    private function getRetriever($type) : IRetriever {
        return Factory::get($type);
    }

    public function seenCarInCollection(Collection $collection) : bool {
        $validator = Factory::get($this->type);
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

    public function removeOldCars() {
        $cars = $this->seenCars()->get();
        if ($cars->count() > 50) {
            $carsToRemove = [];
            foreach ($cars as $car) {
                static $delete = false;
                if ($delete) {
                    $carsToRemove[] = $car->id;
                }
                $delete = !$delete;
            }

            DB::table('cars')->whereIn('id', $carsToRemove)->delete();
            $this->removeOldCars();
        }
    }
}
