<?php

namespace App\Providers;

use App\Repositories\LaravelSessionsRepository;
use Illuminate\Support\ServiceProvider;
use QVGDS\Session\Domain\SessionsRepository;
use QVGDS\Session\Service\SessionsManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind(SessionsRepository::class, LaravelSessionsRepository::class);
        //
        $this->app->bind(SessionsManager::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
