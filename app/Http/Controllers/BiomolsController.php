<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\BiomolCreateRequest;
use App\Http\Requests\BiomolUpdateRequest;
use App\Repositories\BiomolRepository;
use App\Validators\BiomolValidator;

/**
 * Class BiomolsController.
 *
 * @package namespace App\Http\Controllers;
 */
class BiomolsController extends Controller
{
    /**
     * @var BiomolRepository
     */
    protected $repository;

    /**
     * @var BiomolValidator
     */
    protected $validator;

    /**
     * BiomolsController constructor.
     *
     * @param BiomolRepository $repository
     * @param BiomolValidator $validator
     */
    public function __construct(BiomolRepository $repository, BiomolValidator $validator)
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
        $biomols = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $biomols,
            ]);
        }

        return view('biomols.index', compact('biomols'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BiomolCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(BiomolCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $biomol = $this->repository->create($request->all());

            $response = [
                'message' => 'Biomol created.',
                'data'    => $biomol->toArray(),
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
        $biomol = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $biomol,
            ]);
        }

        return view('biomols.show', compact('biomol'));
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
        $biomol = $this->repository->find($id);

        return view('biomols.edit', compact('biomol'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BiomolUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(BiomolUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $biomol = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Biomol updated.',
                'data'    => $biomol->toArray(),
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
                'message' => 'Biomol deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Biomol deleted.');
    }
}
