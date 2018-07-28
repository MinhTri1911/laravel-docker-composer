<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class ValidatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('money', "App\Validators\CustomValidateSpot@validateMoneySpot", 'msg_default');
        Validator::extend('after_date_custom', "App\Validators\CustomValidateSpot@validateAfterDateCustom");
        Validator::extend('exists_service', "App\Validators\CustomValidateSpot@validateExistsService");
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
