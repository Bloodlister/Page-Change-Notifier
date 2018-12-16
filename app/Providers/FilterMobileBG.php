<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class FilterMobileBG extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        \App\FilterMobileBG::created(function($model) {
            /** @var \App\FilterMobileBG $model */
            $model->initiateCarRecords();
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
