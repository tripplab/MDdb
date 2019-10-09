<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\NglRepresentatioonCreateRequest;
use App\Http\Requests\NglRepresentatioonUpdateRequest;
use App\Repositories\NglRepresentatioonRepository;
use App\Validators\NglRepresentatioonValidator;

/**
 * Class NglRepresentatioonsController.
 *
 * @package namespace App\Http\Controllers;
 */
class NglRepresentatioonsController extends Controller
{
    /**
     * @var NglRepresentatioonRepository
     */
    protected $repository;

    /**
     * @var NglRepresentatioonValidator
     */
    protected $validator;

    /**
     * NglRepresentatioonsController constructor.
     *
     * @param NglRepresentatioonRepository $repository
     * @param NglRepresentatioonValidator $validator
     */
    public function __construct(NglRepresentatioonRepository $repository, NglRepresentatioonValidator $validator)
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
        $nglRepresentatioons = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $nglRepresentatioons,
            ]);
        }

        return view('nglRepresentatioons.index', compact('nglRepresentatioons'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  NglRepresentatioonCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(NglRepresentatioonCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $nglRepresentatioon = $this->repository->create($request->all());

            $response = [
                'message' => 'NglRepresentatioon created.',
                'data'    => $nglRepresentatioon->toArray(),
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
        $nglRepresentatioon = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $nglRepresentatioon,
            ]);
        }

        return view('nglRepresentatioons.show', compact('nglRepresentatioon'));
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
        $nglRepresentatioon = $this->repository->find($id);

        return view('nglRepresentatioons.edit', compact('nglRepresentatioon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  NglRepresentatioonUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(NglRepresentatioonUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $nglRepresentatioon = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'NglRepresentatioon updated.',
                'data'    => $nglRepresentatioon->toArray(),
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
                'message' => 'NglRepresentatioon deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'NglRepresentatioon deleted.');
    }
}
