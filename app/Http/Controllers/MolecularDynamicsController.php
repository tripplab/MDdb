<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\MolecularDynamicCreateRequest;
use App\Http\Requests\MolecularDynamicUpdateRequest;
use App\Repositories\MolecularDynamicRepository;
use App\Validators\MolecularDynamicValidator;

/**
 * Class MolecularDynamicsController.
 *
 * @package namespace App\Http\Controllers;
 */
class MolecularDynamicsController extends Controller
{
    /**
     * @var MolecularDynamicRepository
     */
    protected $repository;

    /**
     * @var MolecularDynamicValidator
     */
    protected $validator;

    /**
     * MolecularDynamicsController constructor.
     *
     * @param MolecularDynamicRepository $repository
     * @param MolecularDynamicValidator $validator
     */
    public function __construct(MolecularDynamicRepository $repository, MolecularDynamicValidator $validator)
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
        $molecularDynamics = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $molecularDynamics,
            ]);
        }

        return view('molecularDynamics.index', compact('molecularDynamics'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MolecularDynamicCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(MolecularDynamicCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $molecularDynamic = $this->repository->create($request->all());

            $response = [
                'message' => 'MolecularDynamic created.',
                'data'    => $molecularDynamic->toArray(),
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
        $molecularDynamic = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $molecularDynamic,
            ]);
        }

        return view('molecularDynamics.show', compact('molecularDynamic'));
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
        $molecularDynamic = $this->repository->find($id);

        return view('molecularDynamics.edit', compact('molecularDynamic'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MolecularDynamicUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(MolecularDynamicUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $molecularDynamic = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'MolecularDynamic updated.',
                'data'    => $molecularDynamic->toArray(),
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
                'message' => 'MolecularDynamic deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'MolecularDynamic deleted.');
    }
}
