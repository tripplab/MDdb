<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\htmo_simRepository;
use App\Entities\HtmoSim;
use App\Validators\HtmoSimValidator;

/**
 * Class HtmoSimRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class HtmoSimRepositoryEloquent extends BaseRepository implements HtmoSimRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return HtmoSim::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
