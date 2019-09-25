<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\NglSelectionoSchemeCreateRequest;
use App\Http\Requests\NglSelectionoSchemeUpdateRequest;
use App\Repositories\NglSelectionoSchemeRepository;
use App\Validators\NglSelectionoSchemeValidator;

/**
 * Class NglSelectionoSchemesController.
 *
 * @package namespace App\Http\Controllers;
 */
class NglSelectionoSchemesController extends Controller
{
    /**
     * @var NglSelectionoSchemeRepository
     */
    protected $repository;

    /**
     * @var NglSelectionoSchemeValidator
     */
    protected $validator;

    /**
     * NglSelectionoSchemesController constructor.
     *
     * @param NglSelectionoSchemeRepository $repository
     * @param NglSelectionoSchemeValidator $validator
     */
    public function __construct(NglSelectionoSchemeRepository $repository, NglSelectionoSchemeValidator $validator)
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
        $nglSelectionoSchemes = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $nglSelectionoSchemes,
            ]);
        }

        return view('nglSelectionoSchemes.index', compact('nglSelectionoSchemes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  NglSelectionoSchemeCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(NglSelectionoSchemeCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $nglSelectionoScheme = $this->repository->create($request->all());

            $response = [
                'message' => 'NglSelectionoScheme created.',
                'data'    => $nglSelectionoScheme->toArray(),
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
        $nglSelectionoScheme = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $nglSelectionoScheme,
            ]);
        }

        return view('nglSelectionoSchemes.show', compact('nglSelectionoScheme'));
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
        $nglSelectionoScheme = $this->repository->find($id);

        return view('nglSelectionoSchemes.edit', compact('nglSelectionoScheme'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  NglSelectionoSchemeUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(NglSelectionoSchemeUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $nglSelectionoScheme = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'NglSelectionoScheme updated.',
                'data'    => $nglSelectionoScheme->toArray(),
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
                'message' => 'NglSelectionoScheme deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'NglSelectionoScheme deleted.');
    }
}
