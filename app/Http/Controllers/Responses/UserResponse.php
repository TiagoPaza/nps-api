<?php

namespace App\Http\Responses;

use App\Http\Responses\Transformers\UserTransformer;
use App\User;
use Illuminate\Http\Response;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\JsonApiSerializer;

class UserResponse extends Response
{
    public function __construct(User $user, $status = Response::HTTP_OK)
    {
        $fractal = (new Manager())->setSerializer(new JsonApiSerializer());

        return parent::__construct(
            $fractal->createData(new Item($user, new UserTransformer(), 'user'))->toArray(),
            $status
        );
    }
}
