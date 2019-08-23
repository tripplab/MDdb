<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\HpcCentreRepository;
use App\Entities\HpcCentre;
use App\Validators\HpcCentreValidator;

/**
 * Class HpcCentreRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class HpcCentreRepositoryEloquent extends BaseRepository implements HpcCentreRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return HpcCentre::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
