<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\IpRepository;
use App\Entities\Ip;
use App\Validators\IpValidator;

/**
 * Class IpRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class IpRepositoryEloquent extends BaseRepository implements IpRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Ip::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
