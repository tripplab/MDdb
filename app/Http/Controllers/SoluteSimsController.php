<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\SoluteSimCreateRequest;
use App\Http\Requests\SoluteSimUpdateRequest;
use App\Repositories\SoluteSimRepository;
use App\Validators\SoluteSimValidator;

/**
 * Class SoluteSimsController.
 *
 * @package namespace App\Http\Controllers;
 */
class SoluteSimsController extends Controller
{
    /**
     * @var SoluteSimRepository
     */
    protected $repository;

    /**
     * @var SoluteSimValidator
     */
    protected $validator;

    /**
     * SoluteSimsController constructor.
     *
     * @param SoluteSimRepository $repository
     * @param SoluteSimValidator $validator
     */
    public function __construct(SoluteSimRepository $repository, SoluteSimValidator $validator)
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
        $soluteSims = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $soluteSims,
            ]);
        }

        return view('soluteSims.index', compact('soluteSims'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SoluteSimCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(SoluteSimCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $soluteSim = $this->repository->create($request->all());

            $response = [
                'message' => 'SoluteSim created.',
                'data'    => $soluteSim->toArray(),
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
        $soluteSim = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $soluteSim,
            ]);
        }

        return view('soluteSims.show', compact('soluteSim'));
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
        $soluteSim = $this->repository->find($id);

        return view('soluteSims.edit', compact('soluteSim'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SoluteSimUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(SoluteSimUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $soluteSim = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'SoluteSim updated.',
                'data'    => $soluteSim->toArray(),
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
                'message' => 'SoluteSim deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'SoluteSim deleted.');
    }
}
