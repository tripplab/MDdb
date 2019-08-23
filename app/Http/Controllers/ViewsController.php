<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ViewCreateRequest;
use App\Http\Requests\ViewUpdateRequest;
use App\Repositories\ViewRepository;
use App\Validators\ViewValidator;

/**
 * Class ViewsController.
 *
 * @package namespace App\Http\Controllers;
 */
class ViewsController extends Controller
{
    /**
     * @var ViewRepository
     */
    protected $repository;

    /**
     * @var ViewValidator
     */
    protected $validator;

    /**
     * ViewsController constructor.
     *
     * @param ViewRepository $repository
     * @param ViewValidator $validator
     */
    public function __construct(ViewRepository $repository, ViewValidator $validator)
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
        $views = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $views,
            ]);
        }

        return view('views.index', compact('views'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ViewCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(ViewCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $view = $this->repository->create($request->all());

            $response = [
                'message' => 'View created.',
                'data'    => $view->toArray(),
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
        $view = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $view,
            ]);
        }

        return view('views.show', compact('view'));
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
        $view = $this->repository->find($id);

        return view('views.edit', compact('view'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ViewUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(ViewUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $view = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'View updated.',
                'data'    => $view->toArray(),
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
                'message' => 'View deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'View deleted.');
    }
}
