<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PublishedRepository;
use App\Entities\Published;
use App\Validators\PublishedValidator;

/**
 * Class PublishedRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PublishedRepositoryEloquent extends BaseRepository implements PublishedRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Published::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
