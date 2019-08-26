<?php

namespace App\Http\Responses\Transformers;

use App\PlanActivity;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class PlanActivityTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'user', 'plan'
    ];

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

    /**
     * Include user
     *
     * @param PlanActivity $planActivity
     * @return void|Item
     */
    public function includeUser(PlanActivity $planActivity)
    {
        if ($planActivity->user == null) return;

        return $this->item($planActivity->user, new UserTransformer(), 'user');
    }

    /**
     * Include plan
     *
     * @param PlanActivity $planActivity
     * @return void|Item
     */
    public function includePlan(PlanActivity $planActivity)
    {
        if ($planActivity->plan == null) return;

        return $this->item($planActivity->plan, new PlanTransformer(), 'plan');
    }
}
