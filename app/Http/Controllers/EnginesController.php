<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\EngineCreateRequest;
use App\Http\Requests\EngineUpdateRequest;
use App\Repositories\EngineRepository;
use App\Validators\EngineValidator;

/**
 * Class EnginesController.
 *
 * @package namespace App\Http\Controllers;
 */
class EnginesController extends Controller
{
    /**
     * @var EngineRepository
     */
    protected $repository;

    /**
     * @var EngineValidator
     */
    protected $validator;

    /**
     * EnginesController constructor.
     *
     * @param EngineRepository $repository
     * @param EngineValidator $validator
     */
    public function __construct(EngineRepository $repository, EngineValidator $validator)
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
        $engines = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $engines,
            ]);
        }

        return view('engines.index', compact('engines'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  EngineCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(EngineCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $engine = $this->repository->create($request->all());

            $response = [
                'message' => 'Engine created.',
                'data'    => $engine->toArray(),
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
        $engine = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $engine,
            ]);
        }

        return view('engines.show', compact('engine'));
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
        $engine = $this->repository->find($id);

        return view('engines.edit', compact('engine'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  EngineUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(EngineUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $engine = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Engine updated.',
                'data'    => $engine->toArray(),
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
                'message' => 'Engine deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Engine deleted.');
    }
}
