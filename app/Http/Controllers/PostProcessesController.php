<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\PostProcessCreateRequest;
use App\Http\Requests\PostProcessUpdateRequest;
use App\Repositories\PostProcessRepository;
use App\Validators\PostProcessValidator;

/**
 * Class PostProcessesController.
 *
 * @package namespace App\Http\Controllers;
 */
class PostProcessesController extends Controller
{
    /**
     * @var PostProcessRepository
     */
    protected $repository;

    /**
     * @var PostProcessValidator
     */
    protected $validator;

    /**
     * PostProcessesController constructor.
     *
     * @param PostProcessRepository $repository
     * @param PostProcessValidator $validator
     */
    public function __construct(PostProcessRepository $repository, PostProcessValidator $validator)
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
        $postProcesses = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $postProcesses,
            ]);
        }

        return view('postProcesses.index', compact('postProcesses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PostProcessCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(PostProcessCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $postProcess = $this->repository->create($request->all());

            $response = [
                'message' => 'PostProcess created.',
                'data'    => $postProcess->toArray(),
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
        $postProcess = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $postProcess,
            ]);
        }

        return view('postProcesses.show', compact('postProcess'));
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
        $postProcess = $this->repository->find($id);

        return view('postProcesses.edit', compact('postProcess'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PostProcessUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(PostProcessUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $postProcess = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'PostProcess updated.',
                'data'    => $postProcess->toArray(),
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
                'message' => 'PostProcess deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'PostProcess deleted.');
    }
}
