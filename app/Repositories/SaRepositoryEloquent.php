<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SaRepository;
use App\Entities\Sa;
use App\Validators\SaValidator;

/**
 * Class SaRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SaRepositoryEloquent extends BaseRepository implements SaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Sa::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
