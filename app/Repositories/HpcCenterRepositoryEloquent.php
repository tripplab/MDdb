<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\hpc_centerRepository;
use App\Entities\HpcCenter;
use App\Validators\HpcCenterValidator;

/**
 * Class HpcCenterRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class HpcCenterRepositoryEloquent extends BaseRepository implements HpcCenterRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return HpcCenter::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
