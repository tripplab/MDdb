<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\CountryCreateRequest;
use App\Http\Requests\CountryUpdateRequest;
use App\Repositories\CountryRepository;
use App\Validators\CountryValidator;

/**
 * Class CountriesController.
 *
 * @package namespace App\Http\Controllers;
 */
class CountriesController extends Controller
{
    /**
     * @var CountryRepository
     */
    protected $repository;

    /**
     * @var CountryValidator
     */
    protected $validator;

    /**
     * CountriesController constructor.
     *
     * @param CountryRepository $repository
     * @param CountryValidator $validator
     */
    public function __construct(CountryRepository $repository, CountryValidator $validator)
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
        $countries = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $countries,
            ]);
        }

        return view('countries.index', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CountryCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CountryCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $country = $this->repository->create($request->all());

            $response = [
                'message' => 'Country created.',
                'data'    => $country->toArray(),
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
        $country = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $country,
            ]);
        }

        return view('countries.show', compact('country'));
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
        $country = $this->repository->find($id);

        return view('countries.edit', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CountryUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(CountryUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $country = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Country updated.',
                'data'    => $country->toArray(),
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
                'message' => 'Country deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Country deleted.');
    }
}
