<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\SpdbCreateRequest;
use App\Http\Requests\SpdbUpdateRequest;
use App\Repositories\SpdbRepository;
use App\Validators\SpdbValidator;

/**
 * Class SpdbsController.
 *
 * @package namespace App\Http\Controllers;
 */
class SpdbsController extends Controller
{
    /**
     * @var SpdbRepository
     */
    protected $repository;

    /**
     * @var SpdbValidator
     */
    protected $validator;

    /**
     * SpdbsController constructor.
     *
     * @param SpdbRepository $repository
     * @param SpdbValidator $validator
     */
    public function __construct(SpdbRepository $repository, SpdbValidator $validator)
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
        $spdbs = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $spdbs,
            ]);
        }

        return view('spdbs.index', compact('spdbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SpdbCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(SpdbCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $spdb = $this->repository->create($request->all());

            $response = [
                'message' => 'Spdb created.',
                'data'    => $spdb->toArray(),
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
        $spdb = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $spdb,
            ]);
        }

        return view('spdbs.show', compact('spdb'));
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
        $spdb = $this->repository->find($id);

        return view('spdbs.edit', compact('spdb'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SpdbUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(SpdbUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $spdb = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Spdb updated.',
                'data'    => $spdb->toArray(),
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
                'message' => 'Spdb deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Spdb deleted.');
    }
}
