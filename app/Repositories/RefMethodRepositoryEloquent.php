<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ref_methodRepository;
use App\Entities\RefMethod;
use App\Validators\RefMethodValidator;

/**
 * Class RefMethodRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RefMethodRepositoryEloquent extends BaseRepository implements RefMethodRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RefMethod::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
