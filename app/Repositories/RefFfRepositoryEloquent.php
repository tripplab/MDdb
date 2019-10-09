<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ref_ffRepository;
use App\Entities\RefFf;
use App\Validators\RefFfValidator;

/**
 * Class RefFfRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RefFfRepositoryEloquent extends BaseRepository implements RefFfRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RefFf::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
