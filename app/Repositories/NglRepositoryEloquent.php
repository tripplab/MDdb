<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\NglRepository;
use App\Entities\Ngl;
use App\Validators\NglValidator;

/**
 * Class NglRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class NglRepositoryEloquent extends BaseRepository implements NglRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Ngl::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
