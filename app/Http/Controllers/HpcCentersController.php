<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\HpcCenterCreateRequest;
use App\Http\Requests\HpcCenterUpdateRequest;
use App\Repositories\HpcCenterRepository;
use App\Validators\HpcCenterValidator;

/**
 * Class HpcCentersController.
 *
 * @package namespace App\Http\Controllers;
 */
class HpcCentersController extends Controller
{
    /**
     * @var HpcCenterRepository
     */
    protected $repository;

    /**
     * @var HpcCenterValidator
     */
    protected $validator;

    /**
     * HpcCentersController constructor.
     *
     * @param HpcCenterRepository $repository
     * @param HpcCenterValidator $validator
     */
    public function __construct(HpcCenterRepository $repository, HpcCenterValidator $validator)
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
        $hpcCenters = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $hpcCenters,
            ]);
        }

        return view('hpcCenters.index', compact('hpcCenters'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  HpcCenterCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(HpcCenterCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $hpcCenter = $this->repository->create($request->all());

            $response = [
                'message' => 'HpcCenter created.',
                'data'    => $hpcCenter->toArray(),
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
        $hpcCenter = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $hpcCenter,
            ]);
        }

        return view('hpcCenters.show', compact('hpcCenter'));
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
        $hpcCenter = $this->repository->find($id);

        return view('hpcCenters.edit', compact('hpcCenter'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  HpcCenterUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(HpcCenterUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $hpcCenter = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'HpcCenter updated.',
                'data'    => $hpcCenter->toArray(),
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
                'message' => 'HpcCenter deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'HpcCenter deleted.');
    }
}
