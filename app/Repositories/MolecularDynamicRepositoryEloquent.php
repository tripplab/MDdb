<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MolecularDynamicRepository;
use App\Entities\MolecularDynamic;
use App\Validators\MolecularDynamicValidator;

/**
 * Class MolecularDynamicRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MolecularDynamicRepositoryEloquent extends BaseRepository implements MolecularDynamicRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MolecularDynamic::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return MolecularDynamicValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
