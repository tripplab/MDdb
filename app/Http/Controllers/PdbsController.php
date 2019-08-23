<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\PdbCreateRequest;
use App\Http\Requests\PdbUpdateRequest;
use App\Repositories\PdbRepository;
use App\Validators\PdbValidator;

/**
 * Class PdbsController.
 *
 * @package namespace App\Http\Controllers;
 */
class PdbsController extends Controller
{
    /**
     * @var PdbRepository
     */
    protected $repository;

    /**
     * @var PdbValidator
     */
    protected $validator;

    /**
     * PdbsController constructor.
     *
     * @param PdbRepository $repository
     * @param PdbValidator $validator
     */
    public function __construct(PdbRepository $repository, PdbValidator $validator)
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
        $pdbs = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $pdbs,
            ]);
        }

        return view('pdbs.index', compact('pdbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PdbCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(PdbCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $pdb = $this->repository->create($request->all());

            $response = [
                'message' => 'Pdb created.',
                'data'    => $pdb->toArray(),
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
        $pdb = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $pdb,
            ]);
        }

        return view('pdbs.show', compact('pdb'));
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
        $pdb = $this->repository->find($id);

        return view('pdbs.edit', compact('pdb'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PdbUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(PdbUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $pdb = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Pdb updated.',
                'data'    => $pdb->toArray(),
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
                'message' => 'Pdb deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Pdb deleted.');
    }
}
