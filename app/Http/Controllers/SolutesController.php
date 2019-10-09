<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\SoluteCreateRequest;
use App\Http\Requests\SoluteUpdateRequest;
use App\Repositories\SoluteRepository;
use App\Validators\SoluteValidator;

/**
 * Class SolutesController.
 *
 * @package namespace App\Http\Controllers;
 */
class SolutesController extends Controller
{
    /**
     * @var SoluteRepository
     */
    protected $repository;

    /**
     * @var SoluteValidator
     */
    protected $validator;

    /**
     * SolutesController constructor.
     *
     * @param SoluteRepository $repository
     * @param SoluteValidator $validator
     */
    public function __construct(SoluteRepository $repository, SoluteValidator $validator)
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
        $solutes = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $solutes,
            ]);
        }

        return view('solutes.index', compact('solutes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SoluteCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(SoluteCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $solute = $this->repository->create($request->all());

            $response = [
                'message' => 'Solute created.',
                'data'    => $solute->toArray(),
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
        $solute = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $solute,
            ]);
        }

        return view('solutes.show', compact('solute'));
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
        $solute = $this->repository->find($id);

        return view('solutes.edit', compact('solute'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SoluteUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(SoluteUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $solute = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Solute updated.',
                'data'    => $solute->toArray(),
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
                'message' => 'Solute deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Solute deleted.');
    }
}
