<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\SeCreateRequest;
use App\Http\Requests\SeUpdateRequest;
use App\Repositories\SeRepository;
use App\Validators\SeValidator;

/**
 * Class SesController.
 *
 * @package namespace App\Http\Controllers;
 */
class SesController extends Controller
{
    /**
     * @var SeRepository
     */
    protected $repository;

    /**
     * @var SeValidator
     */
    protected $validator;

    /**
     * SesController constructor.
     *
     * @param SeRepository $repository
     * @param SeValidator $validator
     */
    public function __construct(SeRepository $repository, SeValidator $validator)
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
        $ses = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $ses,
            ]);
        }

        return view('ses.index', compact('ses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SeCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(SeCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $se = $this->repository->create($request->all());

            $response = [
                'message' => 'Se created.',
                'data'    => $se->toArray(),
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
        $se = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $se,
            ]);
        }

        return view('ses.show', compact('se'));
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
        $se = $this->repository->find($id);

        return view('ses.edit', compact('se'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SeUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(SeUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $se = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Se updated.',
                'data'    => $se->toArray(),
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
                'message' => 'Se deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Se deleted.');
    }
}
