<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\soluteRepository;
use App\Entities\Solute;
use App\Validators\SoluteValidator;

/**
 * Class SoluteRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SoluteRepositoryEloquent extends BaseRepository implements SoluteRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Solute::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
