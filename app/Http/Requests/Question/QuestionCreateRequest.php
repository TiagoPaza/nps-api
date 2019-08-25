<?php

namespace App\Http\Requests\PlanActivity;

use App\Http\Requests\JsonRequest;

class QuestionCreateRequest extends JsonRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ask' => 'required|string',
            'ask_optional' => 'required|string',
            'user_id' => 'required|integer:exists:users,id'
        ];
    }
}
