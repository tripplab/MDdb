<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MdRepository;
use App\Entities\Md;
use App\Validators\MdValidator;

/**
 * Class MdRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MdRepositoryEloquent extends BaseRepository implements MdRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Md::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
