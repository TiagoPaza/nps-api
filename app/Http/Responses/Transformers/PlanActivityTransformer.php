<?php

namespace App\Http\Responses\Transformers;

use App\PlanActivity;
use League\Fractal\TransformerAbstract;

class PlanActivityTransformer extends TransformerAbstract
{
    public function transform(PlanActivity $planActivity)
    {
        return [
            'id' => (string)$planActivity->id,
            'questions_current' => $planActivity->questions_current,
            'plan_id' => $planActivity->plan_id,
            'user_id' => $planActivity->user_id,

            'created_at' => $planActivity->created_at ? $planActivity->created_at->getTimestamp() : null,
            'updated_at' => $planActivity->updated_at ? $planActivity->updated_at->getTimestamp() : null,
            'deleted_at' => $planActivity->deleted_at ? $planActivity->deleted_at->getTimestamp() : null,
            'links' => [
                'self' => '/plans/' . $planActivity->id,
            ]
        ];
    }
}
