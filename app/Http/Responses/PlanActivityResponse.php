<?php

namespace App\Http\Responses;

use App\Http\Responses\Transformers\PlanActivityTransformer;
use App\PlanActivity;
use Illuminate\Http\Response;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\JsonApiSerializer;

class PlanActivityResponse extends Response
{
    public function __construct(PlanActivity $planActivity, $status = Response::HTTP_OK)
    {
        $fractal = (new Manager())->setSerializer(new JsonApiSerializer());

        return parent::__construct(
            $fractal->createData(new Item($planActivity, new PlanActivityTransformer(), 'plan-activity'))->toArray(),
            $status
        );
    }
}
