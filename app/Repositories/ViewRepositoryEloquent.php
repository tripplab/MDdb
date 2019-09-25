<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ViewRepository;
use App\Entities\View;
use App\Validators\ViewValidator;

/**
 * Class ViewRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ViewRepositoryEloquent extends BaseRepository implements ViewRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return View::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
