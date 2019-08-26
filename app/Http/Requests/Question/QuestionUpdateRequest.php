<?php

namespace App\Http\Requests\Question;

use App\Http\Requests\JsonRequest;

class QuestionUpdateRequest extends JsonRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ask' => 'string',
            'ask_optional' => '',
            'user_id' => 'integer|exists:users,id',
            'expire_at' => 'date_format:Y-m-d H:i:s'
        ];
    }
}
