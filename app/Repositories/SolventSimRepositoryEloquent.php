<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\solvent_simRepository;
use App\Entities\SolventSim;
use App\Validators\SolventSimValidator;

/**
 * Class SolventSimRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SolventSimRepositoryEloquent extends BaseRepository implements SolventSimRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SolventSim::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
