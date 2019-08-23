<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SpRepository;
use App\Entities\Sp;
use App\Validators\SpValidator;

/**
 * Class SpRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SpRepositoryEloquent extends BaseRepository implements SpRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Sp::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
