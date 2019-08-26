<?php

namespace App\Http\Controllers;

use App\Http\Requests\Plan\PlanCreateRequest;
use App\Http\Requests\Plan\PlanUpdateRequest;
use App\Http\Responses\PlanCollectionResponse;
use App\Http\Responses\PlanResponse;
use App\Plan;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Plan $model
     * @return PlanCollectionResponse|JsonResponse
     */
    public function index(Request $request, Plan $model)
    {
        /** @var LengthAwarePaginator $paginator */
        $paginator = $model->paginate($request->input('limit'))->appends($request->query());
        $plans = $paginator->getCollection();

        return new PlanCollectionResponse($plans, $paginator);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PlanCreateRequest $request
     * @param Plan $model
     * @return PlanResponse|JsonResponse
     */
    public function store(PlanCreateRequest $request, Plan $model)
    {
        $plan = $model->create($request->all());

        return new PlanResponse($plan);
    }

    /**
     * Display the specified resource.
     *
     * @param Plan $plan
     * @return PlanResponse|JsonResponse
     */
    public function show(Plan $plan)
    {
        return new PlanResponse($plan);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PlanUpdateRequest $request
     * @param Plan $plan
     * @return PlanResponse|JsonResponse
     */
    public function update(PlanUpdateRequest $request, Plan $plan)
    {
        $plan->update($request->all());

        return new PlanResponse($plan);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Plan $plan
     * @return Response
     * @throws Exception
     */
    public function destroy(Plan $plan)
    {
        $plan->delete();

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
