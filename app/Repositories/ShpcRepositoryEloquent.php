<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ShpcRepository;
use App\Entities\Shpc;
use App\Validators\ShpcValidator;

/**
 * Class ShpcRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ShpcRepositoryEloquent extends BaseRepository implements ShpcRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Shpc::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
