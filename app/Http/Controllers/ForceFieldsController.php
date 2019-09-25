<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ForceFieldCreateRequest;
use App\Http\Requests\ForceFieldUpdateRequest;
use App\Repositories\ForceFieldRepository;
use App\Validators\ForceFieldValidator;

/**
 * Class ForceFieldsController.
 *
 * @package namespace App\Http\Controllers;
 */
class ForceFieldsController extends Controller
{
    /**
     * @var ForceFieldRepository
     */
    protected $repository;

    /**
     * @var ForceFieldValidator
     */
    protected $validator;

    /**
     * ForceFieldsController constructor.
     *
     * @param ForceFieldRepository $repository
     * @param ForceFieldValidator $validator
     */
    public function __construct(ForceFieldRepository $repository, ForceFieldValidator $validator)
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
        $forceFields = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $forceFields,
            ]);
        }

        return view('forceFields.index', compact('forceFields'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ForceFieldCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(ForceFieldCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $forceField = $this->repository->create($request->all());

            $response = [
                'message' => 'ForceField created.',
                'data'    => $forceField->toArray(),
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
        $forceField = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $forceField,
            ]);
        }

        return view('forceFields.show', compact('forceField'));
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
        $forceField = $this->repository->find($id);

        return view('forceFields.edit', compact('forceField'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ForceFieldUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(ForceFieldUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $forceField = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'ForceField updated.',
                'data'    => $forceField->toArray(),
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
                'message' => 'ForceField deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'ForceField deleted.');
    }
}
