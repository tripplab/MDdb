<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\SpCreateRequest;
use App\Http\Requests\SpUpdateRequest;
use App\Repositories\SpRepository;
use App\Validators\SpValidator;

/**
 * Class SpsController.
 *
 * @package namespace App\Http\Controllers;
 */
class SpsController extends Controller
{
    /**
     * @var SpRepository
     */
    protected $repository;

    /**
     * @var SpValidator
     */
    protected $validator;

    /**
     * SpsController constructor.
     *
     * @param SpRepository $repository
     * @param SpValidator $validator
     */
    public function __construct(SpRepository $repository, SpValidator $validator)
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
        $sps = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $sps,
            ]);
        }

        return view('sps.index', compact('sps'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SpCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(SpCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $sp = $this->repository->create($request->all());

            $response = [
                'message' => 'Sp created.',
                'data'    => $sp->toArray(),
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
        $sp = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $sp,
            ]);
        }

        return view('sps.show', compact('sp'));
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
        $sp = $this->repository->find($id);

        return view('sps.edit', compact('sp'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SpUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(SpUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $sp = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Sp updated.',
                'data'    => $sp->toArray(),
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
                'message' => 'Sp deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Sp deleted.');
    }
}
