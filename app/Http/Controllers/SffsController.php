<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\SffCreateRequest;
use App\Http\Requests\SffUpdateRequest;
use App\Repositories\SffRepository;
use App\Validators\SffValidator;

/**
 * Class SffsController.
 *
 * @package namespace App\Http\Controllers;
 */
class SffsController extends Controller
{
    /**
     * @var SffRepository
     */
    protected $repository;

    /**
     * @var SffValidator
     */
    protected $validator;

    /**
     * SffsController constructor.
     *
     * @param SffRepository $repository
     * @param SffValidator $validator
     */
    public function __construct(SffRepository $repository, SffValidator $validator)
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
        $sffs = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $sffs,
            ]);
        }

        return view('sffs.index', compact('sffs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SffCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(SffCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $sff = $this->repository->create($request->all());

            $response = [
                'message' => 'Sff created.',
                'data'    => $sff->toArray(),
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
        $sff = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $sff,
            ]);
        }

        return view('sffs.show', compact('sff'));
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
        $sff = $this->repository->find($id);

        return view('sffs.edit', compact('sff'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SffUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(SffUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $sff = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Sff updated.',
                'data'    => $sff->toArray(),
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
                'message' => 'Sff deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Sff deleted.');
    }
}
