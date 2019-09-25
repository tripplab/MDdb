<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\MddbConfigCreateRequest;
use App\Http\Requests\MddbConfigUpdateRequest;
use App\Repositories\MddbConfigRepository;
use App\Validators\MddbConfigValidator;

/**
 * Class MddbConfigsController.
 *
 * @package namespace App\Http\Controllers;
 */
class MddbConfigsController extends Controller
{
    /**
     * @var MddbConfigRepository
     */
    protected $repository;

    /**
     * @var MddbConfigValidator
     */
    protected $validator;

    /**
     * MddbConfigsController constructor.
     *
     * @param MddbConfigRepository $repository
     * @param MddbConfigValidator $validator
     */
    public function __construct(MddbConfigRepository $repository, MddbConfigValidator $validator)
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
        $mddbConfigs = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $mddbConfigs,
            ]);
        }

        return view('mddbConfigs.index', compact('mddbConfigs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MddbConfigCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(MddbConfigCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $mddbConfig = $this->repository->create($request->all());

            $response = [
                'message' => 'MddbConfig created.',
                'data'    => $mddbConfig->toArray(),
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
        $mddbConfig = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $mddbConfig,
            ]);
        }

        return view('mddbConfigs.show', compact('mddbConfig'));
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
        $mddbConfig = $this->repository->find($id);

        return view('mddbConfigs.edit', compact('mddbConfig'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MddbConfigUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(MddbConfigUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $mddbConfig = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'MddbConfig updated.',
                'data'    => $mddbConfig->toArray(),
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
                'message' => 'MddbConfig deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'MddbConfig deleted.');
    }
}
