<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\NglSimCreateRequest;
use App\Http\Requests\NglSimUpdateRequest;
use App\Repositories\NglSimRepository;
use App\Validators\NglSimValidator;

/**
 * Class NglSimsController.
 *
 * @package namespace App\Http\Controllers;
 */
class NglSimsController extends Controller
{
    /**
     * @var NglSimRepository
     */
    protected $repository;

    /**
     * @var NglSimValidator
     */
    protected $validator;

    /**
     * NglSimsController constructor.
     *
     * @param NglSimRepository $repository
     * @param NglSimValidator $validator
     */
    public function __construct(NglSimRepository $repository, NglSimValidator $validator)
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
        $nglSims = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $nglSims,
            ]);
        }

        return view('nglSims.index', compact('nglSims'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  NglSimCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(NglSimCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $nglSim = $this->repository->create($request->all());

            $response = [
                'message' => 'NglSim created.',
                'data'    => $nglSim->toArray(),
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
        $nglSim = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $nglSim,
            ]);
        }

        return view('nglSims.show', compact('nglSim'));
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
        $nglSim = $this->repository->find($id);

        return view('nglSims.edit', compact('nglSim'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  NglSimUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(NglSimUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $nglSim = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'NglSim updated.',
                'data'    => $nglSim->toArray(),
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
                'message' => 'NglSim deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'NglSim deleted.');
    }
}
