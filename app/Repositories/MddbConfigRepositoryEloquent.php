<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MddbConfigRepository;
use App\Entities\MddbConfig;
use App\Validators\MddbConfigValidator;

/**
 * Class MddbConfigRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MddbConfigRepositoryEloquent extends BaseRepository implements MddbConfigRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MddbConfig::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
