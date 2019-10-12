<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\Study;
use App\Validators\StudyValidator;

/**
 * Class StudyRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class StudyRepositoryEloquent extends BaseRepository implements StudyRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Study::class;
    }


    public function saveBasic(Request $data_received)
    {
        $study = null;

        $study['is_public'] = $data_received->has('is_public', false);
        $study['llave'] = Hash::make('aleatorio');
        $study['title'] = $data_received->title;
        $study['short_title'] = $data_received->short_title;
        $study['abstract'] = $data_received->abstract;
        $study['funding'] = $data_received->funding;
        #return $data_received;
        $study = $this->create($study);

        $published['DOIpreprint'] = $data_received->published['doi_preprint'];
        $published['DOIpaper'] = $data_received->published['doi_paper'];
        $study->published()->create($published);

        $coauthors = $data_received['coauthors'];
        foreach ($coauthors as $coauthor) {
            $study->coauthors()->create($coauthor);
        }

        $sipran_list = $data_received['sipran_list'];
        foreach ($sipran_list as $related_model) {
            $study->simulationProtocolAnalysis()->create($related_model);
        }

        $postprocess_list = $data_received['postprocess_list'];
        foreach ($postprocess_list as $related_model) {
            $study->postProcess()->create($related_model);
        }

        return $study;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
