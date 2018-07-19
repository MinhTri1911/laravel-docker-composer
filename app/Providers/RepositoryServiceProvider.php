<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
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
            'service' => [
                'interface' => \App\Repositories\Service\ServiceInterface::class,
                'repository' => \App\Repositories\Service\ServiceRepository::class
            ],
            'billingMethod' => [
                'interface' => \App\Repositories\BillingMethod\BillingMethodInterface::class,
                'repository' => \App\Repositories\BillingMethod\BillingMethodRepository::class
            ],
            'contract' => [
                'interface' => \App\Repositories\Contract\ContractInterface::class,
                'repository' => \App\Repositories\Contract\ContractRepository::class
            ],
            'approve' => [
                'interface' => \App\Repositories\Approve\ApproveInterface::class,
                'repository' => \App\Repositories\Approve\ApproveRepository::class
            ],
            'billingPaper' => [
                'interface' => \App\Repositories\Billing\BillingPaperInterface::class,
                'repository' => \App\Repositories\Billing\BillingPaperRepository::class
            ],
            'tshipspot' => [
                'interface' => \App\Repositories\TShipSpot\TShipSpotInterface::class,
                'repository' => \App\Repositories\TShipSpot\TShipSpotRepository::class
            ],
            'mspot' => [
                'interface' => \App\Repositories\MSpot\MSpotInterface::class,
                'repository' => \App\Repositories\MSpot\MSpotRepository::class
            ],
            'mcurrency' => [
                'interface' => \App\Repositories\MCurrency\MCurrencyInterface::class,
                'repository' => \App\Repositories\MCurrency\MCurrencyRepository::class
            ]
        ];
        foreach ($paths as $value) {
            $this->app->singleton($value['interface'], $value['repository']);
        }
    }

}
