<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $paths = [
            'user' => [
                'interface' => \App\Repositories\User\UserRepositoryInterface::class,
                'repository' => \App\Repositories\User\UserEloquentRepository::class,
            ],
            'company' => [
                'interface' => \App\Repositories\Company\CompanyInterface::class,
                'repository' => \App\Repositories\Company\CompanyRepository::class,
            ],
            'ship' => [
                'interface' => \App\Repositories\Ship\ShipInterface::class,
                'repository' => \App\Repositories\Ship\ShipRepository::class
            ],
            'billingMethod' => [
                'interface' => \App\Repositories\BillingMethod\BillingMethodInterface::class,
                'repository' => \App\Repositories\BillingMethod\BillingMethodRepository::class
            ]
        ];

        foreach ($paths as $value) {
            $this->app->singleton($value['interface'], $value['repository'] );
        }
    }
}
