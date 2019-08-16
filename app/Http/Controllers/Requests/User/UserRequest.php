<?php

namespace App\Http\Requests\User;

use App\Http\Requests\JsonRequest;

class UserRequest extends JsonRequest
{
    public function getUserId()
    {
        return $this->json('id');
    }
}
