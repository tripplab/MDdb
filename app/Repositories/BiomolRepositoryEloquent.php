<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\BiomolRepository;
use App\Entities\Biomol;
use App\Validators\BiomolValidator;

/**
 * Class BiomolRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class BiomolRepositoryEloquent extends BaseRepository implements BiomolRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Biomol::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
