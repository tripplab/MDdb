<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\AnalysisCreateRequest;
use App\Http\Requests\AnalysisUpdateRequest;
use App\Repositories\AnalysisRepository;
use App\Validators\AnalysisValidator;

/**
 * Class AnalysesController.
 *
 * @package namespace App\Http\Controllers;
 */
class AnalysesController extends Controller
{
    /**
     * @var AnalysisRepository
     */
    protected $repository;

    /**
     * @var AnalysisValidator
     */
    protected $validator;

    /**
     * AnalysesController constructor.
     *
     * @param AnalysisRepository $repository
     * @param AnalysisValidator $validator
     */
    public function __construct(AnalysisRepository $repository, AnalysisValidator $validator)
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
        $analyses = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $analyses,
            ]);
        }

        return view('analyses.index', compact('analyses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AnalysisCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(AnalysisCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $analysi = $this->repository->create($request->all());

            $response = [
                'message' => 'Analysis created.',
                'data'    => $analysi->toArray(),
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
        $analysi = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $analysi,
            ]);
        }

        return view('analyses.show', compact('analysi'));
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
        $analysi = $this->repository->find($id);

        return view('analyses.edit', compact('analysi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AnalysisUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(AnalysisUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $analysi = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Analysis updated.',
                'data'    => $analysi->toArray(),
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
                'message' => 'Analysis deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Analysis deleted.');
    }
}
