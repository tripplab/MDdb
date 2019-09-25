<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\IpCreateRequest;
use App\Http\Requests\IpUpdateRequest;
use App\Repositories\IpRepository;
use App\Validators\IpValidator;

/**
 * Class IpsController.
 *
 * @package namespace App\Http\Controllers;
 */
class IpsController extends Controller
{
    /**
     * @var IpRepository
     */
    protected $repository;

    /**
     * @var IpValidator
     */
    protected $validator;

    /**
     * IpsController constructor.
     *
     * @param IpRepository $repository
     * @param IpValidator $validator
     */
    public function __construct(IpRepository $repository, IpValidator $validator)
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
        $ips = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $ips,
            ]);
        }

        return view('ips.index', compact('ips'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  IpCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(IpCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $ip = $this->repository->create($request->all());

            $response = [
                'message' => 'Ip created.',
                'data'    => $ip->toArray(),
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
        $ip = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $ip,
            ]);
        }

        return view('ips.show', compact('ip'));
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
        $ip = $this->repository->find($id);

        return view('ips.edit', compact('ip'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  IpUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(IpUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $ip = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Ip updated.',
                'data'    => $ip->toArray(),
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
                'message' => 'Ip deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Ip deleted.');
    }
}
