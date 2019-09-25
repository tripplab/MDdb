<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SffRepository;
use App\Entities\Sff;
use App\Validators\SffValidator;

/**
 * Class SffRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SffRepositoryEloquent extends BaseRepository implements SffRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Sff::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
