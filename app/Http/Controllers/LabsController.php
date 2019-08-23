<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\LabCreateRequest;
use App\Http\Requests\LabUpdateRequest;
use App\Repositories\LabRepository;
use App\Validators\LabValidator;

/**
 * Class LabsController.
 *
 * @package namespace App\Http\Controllers;
 */
class LabsController extends Controller
{
    /**
     * @var LabRepository
     */
    protected $repository;

    /**
     * @var LabValidator
     */
    protected $validator;

    /**
     * LabsController constructor.
     *
     * @param LabRepository $repository
     * @param LabValidator $validator
     */
    public function __construct(LabRepository $repository, LabValidator $validator)
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
        $labs = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $labs,
            ]);
        }

        return view('labs.index', compact('labs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  LabCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(LabCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $lab = $this->repository->create($request->all());

            $response = [
                'message' => 'Lab created.',
                'data'    => $lab->toArray(),
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
        $lab = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $lab,
            ]);
        }

        return view('labs.show', compact('lab'));
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
        $lab = $this->repository->find($id);

        return view('labs.edit', compact('lab'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  LabUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(LabUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $lab = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Lab updated.',
                'data'    => $lab->toArray(),
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
                'message' => 'Lab deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Lab deleted.');
    }
}
