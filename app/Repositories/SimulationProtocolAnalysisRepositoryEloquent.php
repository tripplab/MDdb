<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SimulationProtocolAnalysisRepository;
use App\Entities\SimulationProtocolAnalysis;
use App\Validators\SimulationProtocolAnalysisValidator;

/**
 * Class SimulationProtocolAnalysisRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SimulationProtocolAnalysisRepositoryEloquent extends BaseRepository implements SimulationProtocolAnalysisRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SimulationProtocolAnalysis::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
