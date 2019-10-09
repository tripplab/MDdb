<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\CoauthorsCreateRequest;
use App\Http\Requests\CoauthorsUpdateRequest;
use App\Repositories\CoauthorsRepository;
use App\Validators\CoauthorsValidator;

/**
 * Class CoauthorsController.
 *
 * @package namespace App\Http\Controllers;
 */
class CoauthorsController extends Controller
{
    /**
     * @var CoauthorsRepository
     */
    protected $repository;

    /**
     * @var CoauthorsValidator
     */
    protected $validator;

    /**
     * CoauthorsController constructor.
     *
     * @param CoauthorsRepository $repository
     * @param CoauthorsValidator $validator
     */
    public function __construct(CoauthorsRepository $repository, CoauthorsValidator $validator)
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
        $coauthors = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $coauthors,
            ]);
        }

        return view('coauthors.index', compact('coauthors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CoauthorsCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CoauthorsCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $coauthor = $this->repository->create($request->all());

            $response = [
                'message' => 'Coauthors created.',
                'data'    => $coauthor->toArray(),
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
        $coauthor = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $coauthor,
            ]);
        }

        return view('coauthors.show', compact('coauthor'));
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
        $coauthor = $this->repository->find($id);

        return view('coauthors.edit', compact('coauthor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CoauthorsUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(CoauthorsUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $coauthor = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Coauthors updated.',
                'data'    => $coauthor->toArray(),
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
                'message' => 'Coauthors deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Coauthors deleted.');
    }
}
