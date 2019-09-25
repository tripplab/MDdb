<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\SolventCreateRequest;
use App\Http\Requests\SolventUpdateRequest;
use App\Repositories\SolventRepository;
use App\Validators\SolventValidator;

/**
 * Class SolventsController.
 *
 * @package namespace App\Http\Controllers;
 */
class SolventsController extends Controller
{
    /**
     * @var SolventRepository
     */
    protected $repository;

    /**
     * @var SolventValidator
     */
    protected $validator;

    /**
     * SolventsController constructor.
     *
     * @param SolventRepository $repository
     * @param SolventValidator $validator
     */
    public function __construct(SolventRepository $repository, SolventValidator $validator)
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
        $solvents = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $solvents,
            ]);
        }

        return view('solvents.index', compact('solvents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SolventCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(SolventCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $solvent = $this->repository->create($request->all());

            $response = [
                'message' => 'Solvent created.',
                'data'    => $solvent->toArray(),
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
        $solvent = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $solvent,
            ]);
        }

        return view('solvents.show', compact('solvent'));
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
        $solvent = $this->repository->find($id);

        return view('solvents.edit', compact('solvent'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SolventUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(SolventUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $solvent = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Solvent updated.',
                'data'    => $solvent->toArray(),
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
                'message' => 'Solvent deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Solvent deleted.');
    }
}
