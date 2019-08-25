<?php

namespace App\Http\Requests\PlanActivity;

use App\Http\Requests\JsonRequest;

class PlanActivityCreateRequest extends JsonRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'questions_current' => 'required|integer',
            'plan_id' => 'required|integer|exists:plans,id',
            'user_id' => 'required|integer|exists:users,id'
        ];
    }
}
