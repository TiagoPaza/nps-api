<?php

namespace App\Http\Requests\Plan;

use App\Http\Requests\JsonRequest;

class PlanCreateRequest extends JsonRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->json('id') ? ',' . $this->json('id') : '';

        return [
            'name' => 'required|string|unique:plan' . $id,
            'questions_limit' => 'required|integer'
        ];
    }
}
