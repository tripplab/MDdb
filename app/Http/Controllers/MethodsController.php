<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\MethodCreateRequest;
use App\Http\Requests\MethodUpdateRequest;
use App\Repositories\MethodRepository;
use App\Validators\MethodValidator;

/**
 * Class MethodsController.
 *
 * @package namespace App\Http\Controllers;
 */
class MethodsController extends Controller
{
    /**
     * @var MethodRepository
     */
    protected $repository;

    /**
     * @var MethodValidator
     */
    protected $validator;

    /**
     * MethodsController constructor.
     *
     * @param MethodRepository $repository
     * @param MethodValidator $validator
     */
    public function __construct(MethodRepository $repository, MethodValidator $validator)
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
        $methods = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $methods,
            ]);
        }

        return view('methods.index', compact('methods'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MethodCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(MethodCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $method = $this->repository->create($request->all());

            $response = [
                'message' => 'Method created.',
                'data'    => $method->toArray(),
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
        $method = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $method,
            ]);
        }

        return view('methods.show', compact('method'));
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
        $method = $this->repository->find($id);

        return view('methods.edit', compact('method'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MethodUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(MethodUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $method = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Method updated.',
                'data'    => $method->toArray(),
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
                'message' => 'Method deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Method deleted.');
    }
}
