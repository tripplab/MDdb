<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\HpcCentreCreateRequest;
use App\Http\Requests\HpcCentreUpdateRequest;
use App\Repositories\HpcCentreRepository;
use App\Validators\HpcCentreValidator;

/**
 * Class HpcCentresController.
 *
 * @package namespace App\Http\Controllers;
 */
class HpcCentresController extends Controller
{
    /**
     * @var HpcCentreRepository
     */
    protected $repository;

    /**
     * @var HpcCentreValidator
     */
    protected $validator;

    /**
     * HpcCentresController constructor.
     *
     * @param HpcCentreRepository $repository
     * @param HpcCentreValidator $validator
     */
    public function __construct(HpcCentreRepository $repository, HpcCentreValidator $validator)
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
        $hpcCentres = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $hpcCentres,
            ]);
        }

        return view('hpcCentres.index', compact('hpcCentres'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  HpcCentreCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(HpcCentreCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $hpcCentre = $this->repository->create($request->all());

            $response = [
                'message' => 'HpcCentre created.',
                'data'    => $hpcCentre->toArray(),
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
        $hpcCentre = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $hpcCentre,
            ]);
        }

        return view('hpcCentres.show', compact('hpcCentre'));
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
        $hpcCentre = $this->repository->find($id);

        return view('hpcCentres.edit', compact('hpcCentre'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  HpcCentreUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(HpcCentreUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $hpcCentre = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'HpcCentre updated.',
                'data'    => $hpcCentre->toArray(),
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
                'message' => 'HpcCentre deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'HpcCentre deleted.');
    }
}
