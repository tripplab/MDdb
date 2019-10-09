<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\study_simRepository;
use App\Entities\StudySim;
use App\Validators\StudySimValidator;

/**
 * Class StudySimRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class StudySimRepositoryEloquent extends BaseRepository implements StudySimRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return StudySim::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
