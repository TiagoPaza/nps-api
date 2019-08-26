<?php

namespace App\Http\Responses;

use App\Http\Responses\Transformers\QuestionTransformer;
use App\QuestionReply;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Response;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\JsonApiSerializer;

class QuestionReplyCollectionResponse extends Response
{
    /**
     * @param QuestionReply[]|\Illuminate\Support\Collection $questionReplies
     * @param LengthAwarePaginator $paginator
     */
    public function __construct($questionReplies, $paginator)
    {
        $fractal = (new Manager())->setSerializer(new JsonApiSerializer());
        $resource = new Collection($questionReplies, new QuestionTransformer(), 'question-reply');
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        return parent::__construct($fractal->createData($resource)->toArray());
    }
}
