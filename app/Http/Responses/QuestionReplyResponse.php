<?php

namespace App\Http\Responses;

use App\Http\Responses\Transformers\QuestionReplyTransformer;
use App\QuestionReply;
use Illuminate\Http\Response;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\JsonApiSerializer;

class QuestionReplyResponse extends Response
{
    public function __construct(QuestionReply $questionReply, $status = Response::HTTP_OK)
    {
        $fractal = (new Manager())->setSerializer(new JsonApiSerializer());

        return parent::__construct(
            $fractal->createData(new Item($questionReply, new QuestionReplyTransformer(), 'question-reply'))->toArray(),
            $status
        );
    }
}
