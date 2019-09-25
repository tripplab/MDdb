<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\SmCreateRequest;
use App\Http\Requests\SmUpdateRequest;
use App\Repositories\SmRepository;
use App\Validators\SmValidator;

/**
 * Class SmsController.
 *
 * @package namespace App\Http\Controllers;
 */
class SmsController extends Controller
{
    /**
     * @var SmRepository
     */
    protected $repository;

    /**
     * @var SmValidator
     */
    protected $validator;

    /**
     * SmsController constructor.
     *
     * @param SmRepository $repository
     * @param SmValidator $validator
     */
    public function __construct(SmRepository $repository, SmValidator $validator)
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
        $sms = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $sms,
            ]);
        }

        return view('sms.index', compact('sms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SmCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(SmCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $sm = $this->repository->create($request->all());

            $response = [
                'message' => 'Sm created.',
                'data'    => $sm->toArray(),
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
        $sm = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $sm,
            ]);
        }

        return view('sms.show', compact('sm'));
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
        $sm = $this->repository->find($id);

        return view('sms.edit', compact('sm'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SmUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(SmUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $sm = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Sm updated.',
                'data'    => $sm->toArray(),
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
                'message' => 'Sm deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Sm deleted.');
    }
}
