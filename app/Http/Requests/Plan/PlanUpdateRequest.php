<?php

namespace App\Http\Requests\Plan;

use App\Http\Requests\JsonRequest;

class PlanUpdateRequest extends JsonRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $plan = $this->route('plan');

        return [
            'name' => 'string|unique:plans,name' . $plan->id,
            'questions_limit' => 'integer'
        ];
    }
}
