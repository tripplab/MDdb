<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\App\Repositories\MolecularDynamicRepository::class, \App\Repositories\MolecularDynamicRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MddbConfigRepository::class, \App\Repositories\MddbConfigRepositoryEloquent::class);
        //:end-bindings:
    }
}
