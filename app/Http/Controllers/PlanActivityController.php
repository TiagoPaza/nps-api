<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanActivity\PlanActivityCreateRequest;
use App\Http\Requests\PlanActivity\PlanActivityUpdateRequest;
use App\Http\Responses\PlanActivityCollectionResponse;
use App\Http\Responses\PlanActivityResponse;
use App\PlanActivity;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;

class PlanActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param PlanActivity $model
     * @return PlanActivityCollectionResponse|JsonResponse
     */
    public function index(Request $request, PlanActivity $model)
    {
        /** @var LengthAwarePaginator $paginator */
        $paginator = $model->paginate($request->input('limit'))->appends($request->query());
        $plansActivities = $paginator->getCollection();

        return new PlanActivityCollectionResponse($plansActivities, $paginator);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PlanActivityCreateRequest $request
     * @param PlanActivity $model
     * @return PlanActivityResponse|JsonResponse
     */
    public function store(PlanActivityCreateRequest $request, PlanActivity $model)
    {
        $planActivity = $model->create($request->all());

        return new PlanActivityResponse($planActivity);
    }

    /**
     * Display the specified resource.
     *
     * @param PlanActivity $planActivity
     * @return PlanActivityResponse|JsonResponse
     */
    public function show(PlanActivity $planActivity)
    {
        return new PlanActivityResponse($planActivity);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PlanActivityUpdateRequest $request
     * @param PlanActivity $planActivity
     * @return PlanActivityResponse|JsonResponse
     */
    public function update(PlanActivityUpdateRequest $request, PlanActivity $planActivity)
    {
        $planActivity->update($request->all());

        return new PlanActivityResponse($planActivity);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param PlanActivity $planActivity
     * @return Response
     * @throws Exception
     */
    public function destroy(PlanActivity $planActivity)
    {
        $planActivity->delete();

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
