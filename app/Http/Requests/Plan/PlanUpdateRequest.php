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
        $id = $this->request->get('id') ? ',' . $this->request->get('id') : '';

        return [
            'name' => 'string|unique:plans,name' . $id,
            'questions_limit' => 'integer'
        ];
    }
}
