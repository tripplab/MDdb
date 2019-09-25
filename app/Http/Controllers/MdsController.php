<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\MdCreateRequest;
use App\Http\Requests\MdUpdateRequest;
use App\Repositories\MdRepository;
use App\Validators\MdValidator;

/**
 * Class MdsController.
 *
 * @package namespace App\Http\Controllers;
 */
class MdsController extends Controller
{
    /**
     * @var MdRepository
     */
    protected $repository;

    /**
     * @var MdValidator
     */
    protected $validator;

    /**
     * MdsController constructor.
     *
     * @param MdRepository $repository
     * @param MdValidator $validator
     */
    public function __construct(MdRepository $repository, MdValidator $validator)
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
        $mds = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $mds,
            ]);
        }

        return view('mds.index', compact('mds'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MdCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(MdCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $md = $this->repository->create($request->all());

            $response = [
                'message' => 'Md created.',
                'data'    => $md->toArray(),
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
        $md = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $md,
            ]);
        }

        return view('mds.show', compact('md'));
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
        $md = $this->repository->find($id);

        return view('mds.edit', compact('md'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MdUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(MdUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $md = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Md updated.',
                'data'    => $md->toArray(),
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
                'message' => 'Md deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Md deleted.');
    }
}
