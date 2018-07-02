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
            ]
        ];

        foreach ($paths as $value) {
            $this->app->singleton($value['interface'], $value['repository'] );
        }
    }
}
