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

        $this->app->bind(\App\Repositories\PublishedRepository::class, \App\Repositories\PublishedRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\StudyRepository::class, \App\Repositories\StudyRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RelatedStudyDataRepository::class, \App\Repositories\RelatedStudyDataRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PostProcessRepository::class, \App\Repositories\PostProcessRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\AnalysisRepository::class, \App\Repositories\AnalysisRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SmdRepository::class, \App\Repositories\SmdRepositoryEloquent::class);

        $this->app->bind(\App\Repositories\MethodRepository::class, \App\Repositories\MethodRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\AuthorRepository::class, \App\Repositories\AuthorRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PdbRepository::class, \App\Repositories\PdbRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\HpcCentreRepository::class, \App\Repositories\HpcCentreRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\EngineRepository::class, \App\Repositories\EngineRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ForceFieldRepository::class, \App\Repositories\ForceFieldRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\LabRepository::class, \App\Repositories\LabRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CountryRepository::class, \App\Repositories\CountryRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SolventRepository::class, \App\Repositories\SolventRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\BiomolRepository::class, \App\Repositories\BiomolRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MdRepository::class, \App\Repositories\MdRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\HtmolRepository::class, \App\Repositories\HtmolRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\NglRepository::class, \App\Repositories\NglRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\NglSelectionoSchemeRepository::class, \App\Repositories\NglSelectionoSchemeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\NglRepresentationRepository::class, \App\Repositories\NglRepresentationRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CoauthorsRepository::class, \App\Repositories\CoauthorsRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\DepartmentRepository::class, \App\Repositories\DepartmentRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\HpcCenterRepository::class, \App\Repositories\HpcCenterRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\HtmoSimRepository::class, \App\Repositories\HtmoSimRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\InstitutionRepository::class, \App\Repositories\InstitutionRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\NglRepresentatioonRepository::class, \App\Repositories\NglRepresentatioonRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\NglSelectionSchemeRepository::class, \App\Repositories\NglSelectionSchemeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\NglSimRepository::class, \App\Repositories\NglSimRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RefFfRepository::class, \App\Repositories\RefFfRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RefMethodRepository::class, \App\Repositories\RefMethodRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SimulationRepository::class, \App\Repositories\SimulationRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SoluteRepository::class, \App\Repositories\SoluteRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SoluteSimRepository::class, \App\Repositories\SoluteSimRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SolventSimRepository::class, \App\Repositories\SolventSimRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\StudySimRepository::class, \App\Repositories\StudySimRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\UsersRepository::class, \App\Repositories\UsersRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ViewsRepository::class, \App\Repositories\ViewsRepositoryEloquent::class);
        //:end-bindings:
    }
}
