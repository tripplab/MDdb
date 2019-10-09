<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\StudySimCreateRequest;
use App\Http\Requests\StudySimUpdateRequest;
use App\Repositories\StudySimRepository;
use App\Validators\StudySimValidator;

/**
 * Class StudySimsController.
 *
 * @package namespace App\Http\Controllers;
 */
class StudySimsController extends Controller
{
    /**
     * @var StudySimRepository
     */
    protected $repository;

    /**
     * @var StudySimValidator
     */
    protected $validator;

    /**
     * StudySimsController constructor.
     *
     * @param StudySimRepository $repository
     * @param StudySimValidator $validator
     */
    public function __construct(StudySimRepository $repository, StudySimValidator $validator)
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
        $studySims = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $studySims,
            ]);
        }

        return view('studySims.index', compact('studySims'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StudySimCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(StudySimCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $studySim = $this->repository->create($request->all());

            $response = [
                'message' => 'StudySim created.',
                'data'    => $studySim->toArray(),
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
        $studySim = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $studySim,
            ]);
        }

        return view('studySims.show', compact('studySim'));
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
        $studySim = $this->repository->find($id);

        return view('studySims.edit', compact('studySim'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StudySimUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(StudySimUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $studySim = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'StudySim updated.',
                'data'    => $studySim->toArray(),
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
                'message' => 'StudySim deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'StudySim deleted.');
    }
}
