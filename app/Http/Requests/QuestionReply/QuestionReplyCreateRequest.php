<?php

namespace App\Http\Requests\QuestionReply;

use App\Http\Requests\JsonRequest;

class QuestionReplyCreateRequest extends JsonRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'evaluation' => 'required|integer',
            'response_optional' => '',
            'question_id' => 'required|exists:questions,id'
        ];
    }
}
