<?php

namespace App\Http\Requests\User;

use App\Http\Requests\JsonRequest;

class UserUpdateRequest extends JsonRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = $this->route('user');

        return [
            'social_reason' => 'string|min:3|max:191',
            'fantasy_name' => 'string|min:3|max:191',
            'document_type' => 'string|min:3|max:191',
            'document' => 'string|min:3|max:191|unique:users,document,' . $user->id,
            'state_registration' => 'string|min:3|max:191',
            'email' => 'email|min:3|max:191|unique:users,email,' . $user->id,
            'phone' => 'string|min:3|max:191',
            'cep' => 'string|min:8',
            'address' => 'string|max:191',
            'number' => 'string',
            'complement' => '',
            'password' => 'min:6',
            'state' => 'string',
            'city' => 'string',
            'country' => 'string|min:2|max:2',
            'role' => 'string',
        ];
    }
}
