<?php

namespace App;

use ForceUTF8\Encoding;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Car
 * @package App
 * @property $link
 * @property $image
 * @property $price
 * @property $desc
 * @property $title
 */
class Car extends Model
{
    protected $table = 'cars';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = ['filter_id', 'link'];

    protected $falseFields = ['title', 'image', 'desc', 'price', 'isTopOffer'];

    protected $tempFieldHolder = [];

    protected static function boot() {
        parent::boot();

        self::saving(function($model) {
            /** @var Car $model */
            foreach ($model->falseFields as $falseField) {
                $model->tempFieldHolder[$falseField] = $model->attributes[$falseField];
                unset($model->attributes[$falseField]);
            }
        });

        self::saved(function(Car $model) {
            foreach ($model->falseFields as $falseField) {
                $model->attributes[$falseField] = $model->tempFieldHolder[$falseField];
                unset($model->tempFieldHolder[$falseField]);
            }
        });
    }

    public function getFalseFieldsAttribute() {
        return $this->falseFields;
    }

    public function filter() {
        return $this->belongsTo(Filter::class, 'id');
    }
}
