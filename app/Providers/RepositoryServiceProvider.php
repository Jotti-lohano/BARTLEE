<?php

namespace App\Providers;

use App\Repositories\StretchRepository;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\StretchRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(StretchRepositoryInterface::class, StretchRepository::class);

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
