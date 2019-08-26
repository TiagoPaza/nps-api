<?php

namespace App\Http\Responses\Transformers;

use App\QuestionReply;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class QuestionReplyTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'question'
    ];

    public function transform(QuestionReply $questionReply)
    {
        return [
            'id' => (string)$questionReply->id,
            'evaluation' => $questionReply->evaluation,
            'response_optional' => $questionReply->response_optional,
            'question_id' => $questionReply->question_id,

            'created_at' => $questionReply->created_at ? $questionReply->created_at->getTimestamp() : null,
            'updated_at' => $questionReply->updated_at ? $questionReply->updated_at->getTimestamp() : null,
            'deleted_at' => $questionReply->deleted_at ? $questionReply->deleted_at->getTimestamp() : null,
            'links' => [
                'self' => '/questions/' . $questionReply->id,
            ]
        ];
    }

    /**
     * Include user
     *
     * @param QuestionReply $questionReply
     * @return void|Item
     */
    public function includeQuestion(QuestionReply $questionReply)
    {
        if ($questionReply->question == null) return;

        return $this->item($questionReply->question, new QuestionTransformer(), 'question');
    }
}
