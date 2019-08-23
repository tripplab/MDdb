<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\PublishedCreateRequest;
use App\Http\Requests\PublishedUpdateRequest;
use App\Repositories\PublishedRepository;
use App\Validators\PublishedValidator;

/**
 * Class PublishedsController.
 *
 * @package namespace App\Http\Controllers;
 */
class PublishedsController extends Controller
{
    /**
     * @var PublishedRepository
     */
    protected $repository;

    /**
     * @var PublishedValidator
     */
    protected $validator;

    /**
     * PublishedsController constructor.
     *
     * @param PublishedRepository $repository
     * @param PublishedValidator $validator
     */
    public function __construct(PublishedRepository $repository, PublishedValidator $validator)
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
        $publisheds = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $publisheds,
            ]);
        }

        return view('publisheds.index', compact('publisheds'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PublishedCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(PublishedCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $published = $this->repository->create($request->all());

            $response = [
                'message' => 'Published created.',
                'data'    => $published->toArray(),
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
        $published = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $published,
            ]);
        }

        return view('publisheds.show', compact('published'));
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
        $published = $this->repository->find($id);

        return view('publisheds.edit', compact('published'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PublishedUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(PublishedUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $published = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Published updated.',
                'data'    => $published->toArray(),
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
                'message' => 'Published deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Published deleted.');
    }
}
