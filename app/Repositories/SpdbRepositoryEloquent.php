<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SpdbRepository;
use App\Entities\Spdb;
use App\Validators\SpdbValidator;

/**
 * Class SpdbRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SpdbRepositoryEloquent extends BaseRepository implements SpdbRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Spdb::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
