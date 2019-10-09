<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ngl_selection_schemeRepository;
use App\Entities\NglSelectionScheme;
use App\Validators\NglSelectionSchemeValidator;

/**
 * Class NglSelectionSchemeRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class NglSelectionSchemeRepositoryEloquent extends BaseRepository implements NglSelectionSchemeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return NglSelectionScheme::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
