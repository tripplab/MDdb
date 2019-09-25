<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SmRepository;
use App\Entities\Sm;
use App\Validators\SmValidator;

/**
 * Class SmRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SmRepositoryEloquent extends BaseRepository implements SmRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Sm::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
