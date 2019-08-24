<?php

namespace App\Http\Responses\Transformers;

use App\Plan;
use League\Fractal\TransformerAbstract;

class PlanTransformer extends TransformerAbstract
{
    public function transform(Plan $plan)
    {
        return [
            'id' => (string)$plan->id,
            'name' => $plan->name,
            'questions_limit' => $plan->questions_limit,

            'created_at' => $plan->created_at ? $plan->created_at->getTimestamp() : null,
            'updated_at' => $plan->updated_at ? $plan->updated_at->getTimestamp() : null,
            'deleted_at' => $plan->deleted_at ? $plan->deleted_at->getTimestamp() : null,
            'links' => [
                'self' => '/plans/' . $plan->id,
            ]
        ];
    }
}
