<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'media_object_id' => 'required|integer|exists:media_objects,id',
        ];
    }

    public function getInput()
    {
        return $this->only(['name', 'username', 'email', 'password', 'media_object_id']);
    }
}
