<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Car
 * @package App
 * @property link
 */
class Car extends Model
{
    protected $table = 'cars';

    protected $primaryKey = 'id';

    public $timestamps = true;

    public function filter() {
        return $this->belongsTo(Filter::class, 'id');
    }
}
