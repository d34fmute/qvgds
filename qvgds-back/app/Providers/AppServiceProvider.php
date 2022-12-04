<?php

namespace App\Providers;

use App\Repositories\LaravelGamesRepository;
use App\Repositories\LaravelSessionsRepository;
use Illuminate\Support\ServiceProvider;
use QVGDS\Game\Domain\GamesRepository;
use QVGDS\Game\Service\GamesManager;
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
        $this->app->bind(GamesRepository::class, LaravelGamesRepository::class);
        //
        $this->app->bind(SessionsManager::class);
        $this->app->bind(GamesManager::class);
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
