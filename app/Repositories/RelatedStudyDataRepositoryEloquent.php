<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\RelatedStudyDataRepository;
use App\Entities\RelatedStudyData;
use App\Validators\RelatedStudyDataValidator;

/**
 * Class RelatedStudyDataRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RelatedStudyDataRepositoryEloquent extends BaseRepository implements RelatedStudyDataRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RelatedStudyData::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
