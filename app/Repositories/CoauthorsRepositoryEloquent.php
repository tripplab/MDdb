<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\coauthorsRepository;
use App\Entities\Coauthors;
use App\Validators\CoauthorsValidator;

/**
 * Class CoauthorsRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CoauthorsRepositoryEloquent extends BaseRepository implements CoauthorsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Coauthors::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
