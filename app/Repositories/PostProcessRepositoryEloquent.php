<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PostProcessRepository;
use App\Entities\PostProcess;
use App\Validators\PostProcessValidator;

/**
 * Class PostProcessRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PostProcessRepositoryEloquent extends BaseRepository implements PostProcessRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PostProcess::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
