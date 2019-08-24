<?php

namespace App\Http\Responses;

use App\Http\Responses\Transformers\QuestionTransformer;
use App\Question;
use Illuminate\Http\Response;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\JsonApiSerializer;

class QuestionResponse extends Response
{
    public function __construct(Question $question, $status = Response::HTTP_OK)
    {
        $fractal = (new Manager())->setSerializer(new JsonApiSerializer());

        return parent::__construct(
            $fractal->createData(new Item($question, new QuestionTransformer(), 'question'))->toArray(),
            $status
        );
    }
}
