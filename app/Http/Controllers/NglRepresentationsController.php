<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\NglRepresentationCreateRequest;
use App\Http\Requests\NglRepresentationUpdateRequest;
use App\Repositories\NglRepresentationRepository;
use App\Validators\NglRepresentationValidator;

/**
 * Class NglRepresentationsController.
 *
 * @package namespace App\Http\Controllers;
 */
class NglRepresentationsController extends Controller
{
    /**
     * @var NglRepresentationRepository
     */
    protected $repository;

    /**
     * @var NglRepresentationValidator
     */
    protected $validator;

    /**
     * NglRepresentationsController constructor.
     *
     * @param NglRepresentationRepository $repository
     * @param NglRepresentationValidator $validator
     */
    public function __construct(NglRepresentationRepository $repository, NglRepresentationValidator $validator)
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
        $nglRepresentations = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $nglRepresentations,
            ]);
        }

        return view('nglRepresentations.index', compact('nglRepresentations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  NglRepresentationCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(NglRepresentationCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $nglRepresentation = $this->repository->create($request->all());

            $response = [
                'message' => 'NglRepresentation created.',
                'data'    => $nglRepresentation->toArray(),
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
        $nglRepresentation = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $nglRepresentation,
            ]);
        }

        return view('nglRepresentations.show', compact('nglRepresentation'));
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
        $nglRepresentation = $this->repository->find($id);

        return view('nglRepresentations.edit', compact('nglRepresentation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  NglRepresentationUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(NglRepresentationUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $nglRepresentation = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'NglRepresentation updated.',
                'data'    => $nglRepresentation->toArray(),
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
                'message' => 'NglRepresentation deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'NglRepresentation deleted.');
    }
}
