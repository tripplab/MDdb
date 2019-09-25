<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\HtmolCreateRequest;
use App\Http\Requests\HtmolUpdateRequest;
use App\Repositories\HtmolRepository;
use App\Validators\HtmolValidator;

/**
 * Class HtmolsController.
 *
 * @package namespace App\Http\Controllers;
 */
class HtmolsController extends Controller
{
    /**
     * @var HtmolRepository
     */
    protected $repository;

    /**
     * @var HtmolValidator
     */
    protected $validator;

    /**
     * HtmolsController constructor.
     *
     * @param HtmolRepository $repository
     * @param HtmolValidator $validator
     */
    public function __construct(HtmolRepository $repository, HtmolValidator $validator)
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
        $htmols = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $htmols,
            ]);
        }

        return view('htmols.index', compact('htmols'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  HtmolCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(HtmolCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $htmol = $this->repository->create($request->all());

            $response = [
                'message' => 'Htmol created.',
                'data'    => $htmol->toArray(),
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
        $htmol = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $htmol,
            ]);
        }

        return view('htmols.show', compact('htmol'));
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
        $htmol = $this->repository->find($id);

        return view('htmols.edit', compact('htmol'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  HtmolUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(HtmolUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $htmol = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Htmol updated.',
                'data'    => $htmol->toArray(),
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
                'message' => 'Htmol deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Htmol deleted.');
    }
}
