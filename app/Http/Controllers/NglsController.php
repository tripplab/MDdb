<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\NglCreateRequest;
use App\Http\Requests\NglUpdateRequest;
use App\Repositories\NglRepository;
use App\Validators\NglValidator;

/**
 * Class NglsController.
 *
 * @package namespace App\Http\Controllers;
 */
class NglsController extends Controller
{
    /**
     * @var NglRepository
     */
    protected $repository;

    /**
     * @var NglValidator
     */
    protected $validator;

    /**
     * NglsController constructor.
     *
     * @param NglRepository $repository
     * @param NglValidator $validator
     */
    public function __construct(NglRepository $repository, NglValidator $validator)
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
        $ngls = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $ngls,
            ]);
        }

        return view('ngls.index', compact('ngls'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  NglCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(NglCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $ngl = $this->repository->create($request->all());

            $response = [
                'message' => 'Ngl created.',
                'data'    => $ngl->toArray(),
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
        $ngl = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $ngl,
            ]);
        }

        return view('ngls.show', compact('ngl'));
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
        $ngl = $this->repository->find($id);

        return view('ngls.edit', compact('ngl'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  NglUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(NglUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $ngl = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Ngl updated.',
                'data'    => $ngl->toArray(),
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
                'message' => 'Ngl deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Ngl deleted.');
    }
}
