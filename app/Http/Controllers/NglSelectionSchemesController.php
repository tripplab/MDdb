<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\NglSelectionSchemeCreateRequest;
use App\Http\Requests\NglSelectionSchemeUpdateRequest;
use App\Repositories\NglSelectionSchemeRepository;
use App\Validators\NglSelectionSchemeValidator;

/**
 * Class NglSelectionSchemesController.
 *
 * @package namespace App\Http\Controllers;
 */
class NglSelectionSchemesController extends Controller
{
    /**
     * @var NglSelectionSchemeRepository
     */
    protected $repository;

    /**
     * @var NglSelectionSchemeValidator
     */
    protected $validator;

    /**
     * NglSelectionSchemesController constructor.
     *
     * @param NglSelectionSchemeRepository $repository
     * @param NglSelectionSchemeValidator $validator
     */
    public function __construct(NglSelectionSchemeRepository $repository, NglSelectionSchemeValidator $validator)
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
        $nglSelectionSchemes = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $nglSelectionSchemes,
            ]);
        }

        return view('nglSelectionSchemes.index', compact('nglSelectionSchemes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  NglSelectionSchemeCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(NglSelectionSchemeCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $nglSelectionScheme = $this->repository->create($request->all());

            $response = [
                'message' => 'NglSelectionScheme created.',
                'data'    => $nglSelectionScheme->toArray(),
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
        $nglSelectionScheme = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $nglSelectionScheme,
            ]);
        }

        return view('nglSelectionSchemes.show', compact('nglSelectionScheme'));
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
        $nglSelectionScheme = $this->repository->find($id);

        return view('nglSelectionSchemes.edit', compact('nglSelectionScheme'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  NglSelectionSchemeUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(NglSelectionSchemeUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $nglSelectionScheme = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'NglSelectionScheme updated.',
                'data'    => $nglSelectionScheme->toArray(),
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
                'message' => 'NglSelectionScheme deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'NglSelectionScheme deleted.');
    }
}
