<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\StudyCreateRequest;
use App\Http\Requests\StudyUpdateRequest;
use App\Repositories\StudyRepository;

/**
 * Class StudiesController.
 *
 * @package namespace App\Http\Controllers;
 */
class StudiesController extends Controller
{
    /**
     * @var StudyRepository
     */
    protected $repository;

    /**
     * @var StudyValidator
     */
    protected $validator;

    /**
     * StudiesController constructor.
     *
     * @param StudyRepository $repository
     * @param StudyValidator $validator
     */
    public function __construct(StudyRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $studies = $this->repository->with(['authors', 'coauthors', 'ipViews', 'published'])->all();

        $studies = $studies->map(function($study) {
            $study->views = $study->ipViews->count();
            $study->authors_list = implode(',', $study->authors->pluck('first_name')->toArray());
            $study->coauthors_list = implode(',', $study->coauthors->pluck('first_name')->toArray());
            return $study;
        });

        return response()->json([
            'data' => $studies,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StudyCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(StudyCreateRequest $request)
    {
        try {

            $study = $this->repository->create($request->all());

            $response = [
                'message' => 'Study created.',
                'data'    => $study->toArray(),
            ];

            return response()->json($response);
        } catch (ValidatorException $e) {

            return response()->json([
                'error'   => true,
                'message' => $e->getMessageBag()
            ]);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $study = $this->repository->find($id);


        return response()->json([
            'data' => $study,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $study = $this->repository->find($id);

        return response()->json([
            'data' => $study,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StudyUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(StudyUpdateRequest $request, $id)
    {
        try {

            $study = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Study updated.',
                'data'    => $study->toArray(),
            ];

            return response()->json($response);
        } catch (ValidatorException $e) {

            return response()->json([
                'error'   => true,
                'message' => $e->getMessageBag()
            ]);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        return response()->json([
            'message' => 'Study deleted.',
            'deleted' => $deleted,
        ]);
    }
}
