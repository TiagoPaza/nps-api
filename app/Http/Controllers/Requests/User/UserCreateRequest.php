<?php

namespace App\Http\Requests\User;

class UserCreateRequest extends UserRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'social_reason' => 'required|string|min:3|max:191',
            'fantasy_name' => 'required|string|min:3|max:191',
            'document_type' => 'required|string|min:3|max:191',
            'document' => 'required|string|min:3|max:191|unique:users,document',
            'state_registration' => 'required|string|min:3|max:191',
            'email' => 'required|email|min:3|max:191|unique:users,email',
            'phone' => 'required|string|min:3|max:191',
            'cep' => 'required|string|min:8',
            'address' => 'required|string|max:191',
            'number' => 'required|string',
            'complement' => '',
            'password' => 'required|min:6',
            'state' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string|min:2|max:2',
            'role' => 'required|string'
        ];
    }
}
