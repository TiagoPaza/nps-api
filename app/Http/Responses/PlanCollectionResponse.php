<?php

namespace App\Http\Responses;

use App\Http\Responses\Transformers\PlanTransformer;
use App\Plan;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Response;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\JsonApiSerializer;

class PlanCollectionResponse extends Response
{
    /**
     * @param Plan[]|\Illuminate\Support\Collection $plans
     * @param LengthAwarePaginator $paginator
     */
    public function __construct($plans, $paginator)
    {
        $fractal = (new Manager())->setSerializer(new JsonApiSerializer());
        $resource = new Collection($plans, new PlanTransformer(), 'plan');
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        return parent::__construct($fractal->createData($resource)->toArray());
    }
}
