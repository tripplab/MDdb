<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\RefMethodCreateRequest;
use App\Http\Requests\RefMethodUpdateRequest;
use App\Repositories\RefMethodRepository;
use App\Validators\RefMethodValidator;

/**
 * Class RefMethodsController.
 *
 * @package namespace App\Http\Controllers;
 */
class RefMethodsController extends Controller
{
    /**
     * @var RefMethodRepository
     */
    protected $repository;

    /**
     * @var RefMethodValidator
     */
    protected $validator;

    /**
     * RefMethodsController constructor.
     *
     * @param RefMethodRepository $repository
     * @param RefMethodValidator $validator
     */
    public function __construct(RefMethodRepository $repository, RefMethodValidator $validator)
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
        $refMethods = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $refMethods,
            ]);
        }

        return view('refMethods.index', compact('refMethods'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RefMethodCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(RefMethodCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $refMethod = $this->repository->create($request->all());

            $response = [
                'message' => 'RefMethod created.',
                'data'    => $refMethod->toArray(),
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
        $refMethod = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $refMethod,
            ]);
        }

        return view('refMethods.show', compact('refMethod'));
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
        $refMethod = $this->repository->find($id);

        return view('refMethods.edit', compact('refMethod'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RefMethodUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(RefMethodUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $refMethod = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'RefMethod updated.',
                'data'    => $refMethod->toArray(),
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
                'message' => 'RefMethod deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'RefMethod deleted.');
    }
}
