<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SolventRepository;
use App\Entities\Solvent;
use App\Validators\SolventValidator;

/**
 * Class SolventRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SolventRepositoryEloquent extends BaseRepository implements SolventRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Solvent::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
