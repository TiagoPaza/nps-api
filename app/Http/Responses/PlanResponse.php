<?php

namespace App\Http\Responses;

use App\Http\Responses\Transformers\PlanTransformer;
use App\Plan;
use Illuminate\Http\Response;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\JsonApiSerializer;

class PlanResponse extends Response
{
    public function __construct(Plan $plan, $status = Response::HTTP_OK)
    {
        $fractal = (new Manager())->setSerializer(new JsonApiSerializer());

        return parent::__construct(
            $fractal->createData(new Item($plan, new PlanTransformer(), 'plan'))->toArray(),
            $status
        );
    }
}
