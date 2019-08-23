<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\AnalysisRepository;
use App\Entities\Analysis;
use App\Validators\AnalysisValidator;

/**
 * Class AnalysisRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AnalysisRepositoryEloquent extends BaseRepository implements AnalysisRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Analysis::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
