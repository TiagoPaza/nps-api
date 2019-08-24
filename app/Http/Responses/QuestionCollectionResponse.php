<?php

namespace App\Http\Responses;

use App\Http\Responses\Transformers\QuestionTransformer;
use App\Question;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Response;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\JsonApiSerializer;

class QuestionCollectionResponse extends Response
{
    /**
     * @param Question[]|\Illuminate\Support\Collection $questions
     * @param LengthAwarePaginator $paginator
     */
    public function __construct($questions, $paginator)
    {
        $fractal = (new Manager())->setSerializer(new JsonApiSerializer());
        $resource = new Collection($questions, new QuestionTransformer(), 'question');
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        return parent::__construct($fractal->createData($resource)->toArray());
    }
}
