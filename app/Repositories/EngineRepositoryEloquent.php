<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EngineRepository;
use App\Entities\Engine;
use App\Validators\EngineValidator;

/**
 * Class EngineRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EngineRepositoryEloquent extends BaseRepository implements EngineRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Engine::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
