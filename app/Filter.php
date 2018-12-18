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

    protected $fillable = ['type', 'search_params'];

    public function user() {
        return $this->belongsTo(User::class, 'id');
    }

    public function setSearchParamsAttribute($value) {
        $this->attributes['search_params'] = \json_encode($value);
    }

    public function getSearchParamsAttribute() {
        $search_params = json_decode($this->attributes['search_params'], true);

        if ($this->type == "MobileBG" && $search_params['f9'] === 'BGN') {
            $search_params['f9'] = 'лв.';
        }

        return $search_params;
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
        $searchParams = $this->search_params;
        if ($this->type && $searchParams['f9'] != 'лв.' && $this->attributes['search_params']['f9'] == 'BGN') {
            $searchParams['f9'] = 'лв.';
        }
        $initialCars = $carRetriever->getCars(['search_params' => $this->getSearchParamsAttribute()], 1);
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
}
