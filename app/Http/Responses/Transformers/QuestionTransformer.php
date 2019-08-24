<?php

namespace App\Http\Responses\Transformers;

use App\Question;
use League\Fractal\TransformerAbstract;

class QuestionTransformer extends TransformerAbstract
{
    public function transform(Question $question)
    {
        return [
            'id' => (string)$question->id,
            'ask' => $question->ask,
            'ask_optional' => $question->ask_optional,

            'created_at' => $question->created_at ? $question->created_at->getTimestamp() : null,
            'updated_at' => $question->updated_at ? $question->updated_at->getTimestamp() : null,
            'deleted_at' => $question->deleted_at ? $question->deleted_at->getTimestamp() : null,
            'links' => [
                'self' => '/questions/' . $question->id,
            ]
        ];
    }
}
