<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\SolventSimCreateRequest;
use App\Http\Requests\SolventSimUpdateRequest;
use App\Repositories\SolventSimRepository;
use App\Validators\SolventSimValidator;

/**
 * Class SolventSimsController.
 *
 * @package namespace App\Http\Controllers;
 */
class SolventSimsController extends Controller
{
    /**
     * @var SolventSimRepository
     */
    protected $repository;

    /**
     * @var SolventSimValidator
     */
    protected $validator;

    /**
     * SolventSimsController constructor.
     *
     * @param SolventSimRepository $repository
     * @param SolventSimValidator $validator
     */
    public function __construct(SolventSimRepository $repository, SolventSimValidator $validator)
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
        $solventSims = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $solventSims,
            ]);
        }

        return view('solventSims.index', compact('solventSims'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SolventSimCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(SolventSimCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $solventSim = $this->repository->create($request->all());

            $response = [
                'message' => 'SolventSim created.',
                'data'    => $solventSim->toArray(),
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
        $solventSim = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $solventSim,
            ]);
        }

        return view('solventSims.show', compact('solventSim'));
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
        $solventSim = $this->repository->find($id);

        return view('solventSims.edit', compact('solventSim'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SolventSimUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(SolventSimUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $solventSim = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'SolventSim updated.',
                'data'    => $solventSim->toArray(),
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
                'message' => 'SolventSim deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'SolventSim deleted.');
    }
}
