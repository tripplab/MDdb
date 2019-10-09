<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\SimulationCreateRequest;
use App\Http\Requests\SimulationUpdateRequest;
use App\Repositories\SimulationRepository;
use App\Validators\SimulationValidator;

/**
 * Class SimulationsController.
 *
 * @package namespace App\Http\Controllers;
 */
class SimulationsController extends Controller
{
    /**
     * @var SimulationRepository
     */
    protected $repository;

    /**
     * @var SimulationValidator
     */
    protected $validator;

    /**
     * SimulationsController constructor.
     *
     * @param SimulationRepository $repository
     * @param SimulationValidator $validator
     */
    public function __construct(SimulationRepository $repository, SimulationValidator $validator)
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
        $simulations = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $simulations,
            ]);
        }

        return view('simulations.index', compact('simulations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SimulationCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(SimulationCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $simulation = $this->repository->create($request->all());

            $response = [
                'message' => 'Simulation created.',
                'data'    => $simulation->toArray(),
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
        $simulation = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $simulation,
            ]);
        }

        return view('simulations.show', compact('simulation'));
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
        $simulation = $this->repository->find($id);

        return view('simulations.edit', compact('simulation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SimulationUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(SimulationUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $simulation = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Simulation updated.',
                'data'    => $simulation->toArray(),
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
                'message' => 'Simulation deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Simulation deleted.');
    }
}
