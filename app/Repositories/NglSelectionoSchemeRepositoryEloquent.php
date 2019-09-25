<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\NglSelectionoSchemeRepository;
use App\Entities\NglSelectionoScheme;
use App\Validators\NglSelectionoSchemeValidator;

/**
 * Class NglSelectionoSchemeRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class NglSelectionoSchemeRepositoryEloquent extends BaseRepository implements NglSelectionoSchemeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return NglSelectionoScheme::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
