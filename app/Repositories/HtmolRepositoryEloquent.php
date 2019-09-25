<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\HtmolRepository;
use App\Entities\Htmol;
use App\Validators\HtmolValidator;

/**
 * Class HtmolRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class HtmolRepositoryEloquent extends BaseRepository implements HtmolRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Htmol::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
