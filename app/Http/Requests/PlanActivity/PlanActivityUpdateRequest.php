<?php

namespace App\Http\Requests\PlanActivity;

use App\Http\Requests\JsonRequest;

class PlanActivityUpdateRequest extends JsonRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'questions_current' => 'integer',
            'plan_id' => 'integer|exists:plans,id',
            'user_id' => 'integer|exists:users,id'
        ];
    }
}
