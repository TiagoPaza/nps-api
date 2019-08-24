<?php

namespace App\Http\Responses\Transformers;

use App\QuestionReply;
use League\Fractal\TransformerAbstract;

class QuestionReplyTransformer extends TransformerAbstract
{
    public function transform(QuestionReply $questionReply)
    {
        return [
            'id' => (string)$questionReply->id,
            'evaluation' => $questionReply->evaluation,
            'response_optional' => $questionReply->response_optional,

            'created_at' => $questionReply->created_at ? $questionReply->created_at->getTimestamp() : null,
            'updated_at' => $questionReply->updated_at ? $questionReply->updated_at->getTimestamp() : null,
            'deleted_at' => $questionReply->deleted_at ? $questionReply->deleted_at->getTimestamp() : null,
            'links' => [
                'self' => '/questions/' . $questionReply->id,
            ]
        ];
    }
}
