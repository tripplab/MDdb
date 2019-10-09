<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ngl_simRepository;
use App\Entities\NglSim;
use App\Validators\NglSimValidator;

/**
 * Class NglSimRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class NglSimRepositoryEloquent extends BaseRepository implements NglSimRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return NglSim::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
