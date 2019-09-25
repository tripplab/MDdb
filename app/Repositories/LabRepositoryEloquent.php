<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\LabRepository;
use App\Entities\Lab;
use App\Validators\LabValidator;

/**
 * Class LabRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class LabRepositoryEloquent extends BaseRepository implements LabRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Lab::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
