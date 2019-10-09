<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\RefFfCreateRequest;
use App\Http\Requests\RefFfUpdateRequest;
use App\Repositories\RefFfRepository;
use App\Validators\RefFfValidator;

/**
 * Class RefFfsController.
 *
 * @package namespace App\Http\Controllers;
 */
class RefFfsController extends Controller
{
    /**
     * @var RefFfRepository
     */
    protected $repository;

    /**
     * @var RefFfValidator
     */
    protected $validator;

    /**
     * RefFfsController constructor.
     *
     * @param RefFfRepository $repository
     * @param RefFfValidator $validator
     */
    public function __construct(RefFfRepository $repository, RefFfValidator $validator)
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
        $refFfs = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $refFfs,
            ]);
        }

        return view('refFfs.index', compact('refFfs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RefFfCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(RefFfCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $refFf = $this->repository->create($request->all());

            $response = [
                'message' => 'RefFf created.',
                'data'    => $refFf->toArray(),
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
        $refFf = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $refFf,
            ]);
        }

        return view('refFfs.show', compact('refFf'));
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
        $refFf = $this->repository->find($id);

        return view('refFfs.edit', compact('refFf'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RefFfUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(RefFfUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $refFf = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'RefFf updated.',
                'data'    => $refFf->toArray(),
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
                'message' => 'RefFf deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'RefFf deleted.');
    }
}
