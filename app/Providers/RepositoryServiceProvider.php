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
        $this->app->bind(\App\Repositories\ViewRepository::class, \App\Repositories\ViewRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\IpRepository::class, \App\Repositories\IpRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SpRepository::class, \App\Repositories\SpRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PublishedRepository::class, \App\Repositories\PublishedRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\StudyRepository::class, \App\Repositories\StudyRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RelatedStudyDataRepository::class, \App\Repositories\RelatedStudyDataRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PostProcessRepository::class, \App\Repositories\PostProcessRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\AnalysisRepository::class, \App\Repositories\AnalysisRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SmdRepository::class, \App\Repositories\SmdRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SaRepository::class, \App\Repositories\SaRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SpdbRepository::class, \App\Repositories\SpdbRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ShpcRepository::class, \App\Repositories\ShpcRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SeRepository::class, \App\Repositories\SeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SffRepository::class, \App\Repositories\SffRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SmRepository::class, \App\Repositories\SmRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MethodRepository::class, \App\Repositories\MethodRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\AuthorRepository::class, \App\Repositories\AuthorRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PdbRepository::class, \App\Repositories\PdbRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\HpcCentreRepository::class, \App\Repositories\HpcCentreRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\EngineRepository::class, \App\Repositories\EngineRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ForceFieldRepository::class, \App\Repositories\ForceFieldRepositoryEloquent::class);
        //:end-bindings:
    }
}
