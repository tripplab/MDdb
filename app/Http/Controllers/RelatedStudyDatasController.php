<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\RelatedStudyDataCreateRequest;
use App\Http\Requests\RelatedStudyDataUpdateRequest;
use App\Repositories\RelatedStudyDataRepository;
use App\Validators\RelatedStudyDataValidator;

/**
 * Class RelatedStudyDatasController.
 *
 * @package namespace App\Http\Controllers;
 */
class RelatedStudyDatasController extends Controller
{
    /**
     * @var RelatedStudyDataRepository
     */
    protected $repository;

    /**
     * @var RelatedStudyDataValidator
     */
    protected $validator;

    /**
     * RelatedStudyDatasController constructor.
     *
     * @param RelatedStudyDataRepository $repository
     * @param RelatedStudyDataValidator $validator
     */
    public function __construct(RelatedStudyDataRepository $repository, RelatedStudyDataValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $relatedStudyDatas = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $relatedStudyDatas,
            ]);
        }

        return view('relatedStudyDatas.index', compact('relatedStudyDatas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RelatedStudyDataCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(RelatedStudyDataCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $relatedStudyDatum = $this->repository->create($request->all());

            $response = [
                'message' => 'RelatedStudyData created.',
                'data'    => $relatedStudyDatum->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
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
        $relatedStudyDatum = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $relatedStudyDatum,
            ]);
        }

        return view('relatedStudyDatas.show', compact('relatedStudyDatum'));
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
        $relatedStudyDatum = $this->repository->find($id);

        return view('relatedStudyDatas.edit', compact('relatedStudyDatum'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RelatedStudyDataUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(RelatedStudyDataUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $relatedStudyDatum = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'RelatedStudyData updated.',
                'data'    => $relatedStudyDatum->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
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

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'RelatedStudyData deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'RelatedStudyData deleted.');
    }
}
