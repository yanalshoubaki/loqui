<?php

namespace App\Http\Requests\WebRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'message' => 'required|string',
            'is_anon' => 'required|boolean',
            'user_id' => [
                'required', 'exists:users,id', function ($attribute, $value, $fail) {
                    if ($value == Auth::id()) {
                        $fail("You can't send message to yourself");
                    }
                },
            ],
            'sender_id' => [
                'required', 'exists:users,id',
            ],
        ];
    }

    public function getInputs(): array
    {
        return $this->only([
            'message', 'is_anon', 'user_id', 'sender_id',
        ]);
    }
}
