<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\SaCreateRequest;
use App\Http\Requests\SaUpdateRequest;
use App\Repositories\SaRepository;
use App\Validators\SaValidator;

/**
 * Class SasController.
 *
 * @package namespace App\Http\Controllers;
 */
class SasController extends Controller
{
    /**
     * @var SaRepository
     */
    protected $repository;

    /**
     * @var SaValidator
     */
    protected $validator;

    /**
     * SasController constructor.
     *
     * @param SaRepository $repository
     * @param SaValidator $validator
     */
    public function __construct(SaRepository $repository, SaValidator $validator)
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
        $sas = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $sas,
            ]);
        }

        return view('sas.index', compact('sas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SaCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(SaCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $sa = $this->repository->create($request->all());

            $response = [
                'message' => 'Sa created.',
                'data'    => $sa->toArray(),
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
        $sa = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $sa,
            ]);
        }

        return view('sas.show', compact('sa'));
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
        $sa = $this->repository->find($id);

        return view('sas.edit', compact('sa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SaUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(SaUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $sa = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Sa updated.',
                'data'    => $sa->toArray(),
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
                'message' => 'Sa deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Sa deleted.');
    }
}
