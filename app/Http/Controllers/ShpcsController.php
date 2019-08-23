<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ShpcCreateRequest;
use App\Http\Requests\ShpcUpdateRequest;
use App\Repositories\ShpcRepository;
use App\Validators\ShpcValidator;

/**
 * Class ShpcsController.
 *
 * @package namespace App\Http\Controllers;
 */
class ShpcsController extends Controller
{
    /**
     * @var ShpcRepository
     */
    protected $repository;

    /**
     * @var ShpcValidator
     */
    protected $validator;

    /**
     * ShpcsController constructor.
     *
     * @param ShpcRepository $repository
     * @param ShpcValidator $validator
     */
    public function __construct(ShpcRepository $repository, ShpcValidator $validator)
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
        $shpcs = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $shpcs,
            ]);
        }

        return view('shpcs.index', compact('shpcs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ShpcCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(ShpcCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $shpc = $this->repository->create($request->all());

            $response = [
                'message' => 'Shpc created.',
                'data'    => $shpc->toArray(),
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
        $shpc = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $shpc,
            ]);
        }

        return view('shpcs.show', compact('shpc'));
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
        $shpc = $this->repository->find($id);

        return view('shpcs.edit', compact('shpc'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ShpcUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(ShpcUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $shpc = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Shpc updated.',
                'data'    => $shpc->toArray(),
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
                'message' => 'Shpc deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Shpc deleted.');
    }
}
