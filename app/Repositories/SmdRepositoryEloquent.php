<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SmdRepository;
use App\Entities\Smd;
use App\Validators\SmdValidator;

/**
 * Class SmdRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SmdRepositoryEloquent extends BaseRepository implements SmdRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Smd::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
