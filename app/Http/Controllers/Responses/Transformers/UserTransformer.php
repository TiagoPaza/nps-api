<?php

namespace App\Http\Responses\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id' => (string)$user->id,
            'social_reason' => $user->social_reason,
            'fantasy_name' => $user->fantasy_name,
            'document' => $user->document,
            'document_type' => $user->document_type,
            'state_registration' => $user->state_registration,
            'email' => $user->email,
            'phone' => $user->phone,
            'cep' => $user->cep,

            'address' => $user->address,
            'number' => $user->number,
            'complement' => $user->complement,

            'state' => $user->state,
            'city' => $user->city,
            'country' => $user->country,

            'roles' => $user->getRoleNames(),

            'email_verified_at' => $user->email_verified_at ? $user->email_verified_at->getTimestamp() : null,
            'created_at' => $user->created_at ? $user->created_at->getTimestamp() : null,
            'updated_at' => $user->updated_at ? $user->updated_at->getTimestamp() : null,
            'deleted_at' => $user->deleted_at ? $user->deleted_at->getTimestamp() : null,
            'links' => [
                'self' => '/users/' . $user->id,
            ]
        ];
    }
}
