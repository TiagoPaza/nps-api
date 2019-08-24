<?php

namespace App\Http\Responses;

use App\Http\Responses\Transformers\PlanActivityTransformer;
use App\PlanActivity;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Response;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\JsonApiSerializer;

class PlanActivityCollectionResponse extends Response
{
    /**
     * @param PlanActivity[]|\Illuminate\Support\Collection $plansActivity
     * @param LengthAwarePaginator $paginator
     */
    public function __construct($plansActivity, $paginator)
    {
        $fractal = (new Manager())->setSerializer(new JsonApiSerializer());
        $resource = new Collection($plansActivity, new PlanActivityTransformer(), 'plan-activity');
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        return parent::__construct($fractal->createData($resource)->toArray());
    }
}
