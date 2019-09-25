<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PdbRepository;
use App\Entities\Pdb;
use App\Validators\PdbValidator;

/**
 * Class PdbRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PdbRepositoryEloquent extends BaseRepository implements PdbRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Pdb::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
