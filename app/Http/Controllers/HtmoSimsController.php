<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\HtmoSimCreateRequest;
use App\Http\Requests\HtmoSimUpdateRequest;
use App\Repositories\HtmoSimRepository;
use App\Validators\HtmoSimValidator;

/**
 * Class HtmoSimsController.
 *
 * @package namespace App\Http\Controllers;
 */
class HtmoSimsController extends Controller
{
    /**
     * @var HtmoSimRepository
     */
    protected $repository;

    /**
     * @var HtmoSimValidator
     */
    protected $validator;

    /**
     * HtmoSimsController constructor.
     *
     * @param HtmoSimRepository $repository
     * @param HtmoSimValidator $validator
     */
    public function __construct(HtmoSimRepository $repository, HtmoSimValidator $validator)
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
        $htmoSims = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $htmoSims,
            ]);
        }

        return view('htmoSims.index', compact('htmoSims'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  HtmoSimCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(HtmoSimCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $htmoSim = $this->repository->create($request->all());

            $response = [
                'message' => 'HtmoSim created.',
                'data'    => $htmoSim->toArray(),
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
        $htmoSim = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $htmoSim,
            ]);
        }

        return view('htmoSims.show', compact('htmoSim'));
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
        $htmoSim = $this->repository->find($id);

        return view('htmoSims.edit', compact('htmoSim'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  HtmoSimUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(HtmoSimUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $htmoSim = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'HtmoSim updated.',
                'data'    => $htmoSim->toArray(),
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
                'message' => 'HtmoSim deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'HtmoSim deleted.');
    }
}
