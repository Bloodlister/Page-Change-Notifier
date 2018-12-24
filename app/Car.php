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

    protected static function boot() {
        parent::boot();
        self::saving(function($model) {
            /** @var Car $model */
            foreach ($model->falseFields as $falseField) {
                unset($model->attributes[$falseField]);
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
