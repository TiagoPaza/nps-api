<?php

namespace App\Http\Requests\Question;

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
            'ask_optional' => '',
            'user_id' => 'required|integer:exists:users,id',
            'expire_at' => 'required|date_format:Y-m-d H:i:s'
        ];
    }
}
