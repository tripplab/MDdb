<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\NglRepresentationRepository;
use App\Entities\NglRepresentation;
use App\Validators\NglRepresentationValidator;

/**
 * Class NglRepresentationRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class NglRepresentationRepositoryEloquent extends BaseRepository implements NglRepresentationRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return NglRepresentation::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
