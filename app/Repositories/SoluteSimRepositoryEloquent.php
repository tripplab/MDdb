<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\solute_simRepository;
use App\Entities\SoluteSim;
use App\Validators\SoluteSimValidator;

/**
 * Class SoluteSimRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SoluteSimRepositoryEloquent extends BaseRepository implements SoluteSimRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SoluteSim::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
