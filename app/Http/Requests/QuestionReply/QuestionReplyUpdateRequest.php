<?php

namespace App\Http\Requests\QuestionReply;

use App\Http\Requests\JsonRequest;

class QuestionReplyUpdateRequest extends JsonRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'evaluation' => 'integer',
            'response_optional' => '',
            'question_id' => 'exists:questions,id'
        ];
    }
}
