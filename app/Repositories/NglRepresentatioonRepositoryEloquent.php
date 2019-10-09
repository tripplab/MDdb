<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ngl_representatioonRepository;
use App\Entities\NglRepresentatioon;
use App\Validators\NglRepresentatioonValidator;

/**
 * Class NglRepresentatioonRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class NglRepresentatioonRepositoryEloquent extends BaseRepository implements NglRepresentatioonRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return NglRepresentatioon::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
