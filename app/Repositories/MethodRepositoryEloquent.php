<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MethodRepository;
use App\Entities\Method;
use App\Validators\MethodValidator;

/**
 * Class MethodRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MethodRepositoryEloquent extends BaseRepository implements MethodRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Method::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
