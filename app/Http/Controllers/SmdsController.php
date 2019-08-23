<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\SmdCreateRequest;
use App\Http\Requests\SmdUpdateRequest;
use App\Repositories\SmdRepository;
use App\Validators\SmdValidator;

/**
 * Class SmdsController.
 *
 * @package namespace App\Http\Controllers;
 */
class SmdsController extends Controller
{
    /**
     * @var SmdRepository
     */
    protected $repository;

    /**
     * @var SmdValidator
     */
    protected $validator;

    /**
     * SmdsController constructor.
     *
     * @param SmdRepository $repository
     * @param SmdValidator $validator
     */
    public function __construct(SmdRepository $repository, SmdValidator $validator)
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
        $smds = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $smds,
            ]);
        }

        return view('smds.index', compact('smds'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SmdCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(SmdCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $smd = $this->repository->create($request->all());

            $response = [
                'message' => 'Smd created.',
                'data'    => $smd->toArray(),
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
        $smd = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $smd,
            ]);
        }

        return view('smds.show', compact('smd'));
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
        $smd = $this->repository->find($id);

        return view('smds.edit', compact('smd'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SmdUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(SmdUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $smd = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Smd updated.',
                'data'    => $smd->toArray(),
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
                'message' => 'Smd deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Smd deleted.');
    }
}
