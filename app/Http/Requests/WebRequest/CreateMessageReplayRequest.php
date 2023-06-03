<?php

namespace App\Http\Requests\WebRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateMessageReplayRequest extends FormRequest
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
            'replay' => 'required|string',
            'image_id' => 'nullable|exists:media_objects,id',
            'user_id' => ['required', function ($attribute, $value, $fail) {
                if ($value != Auth::id()) {
                    $fail("You can't replay this message");
                }
            }],
            'message_id' => 'required|exists:messages,id'
        ];
    }

    public function getInputs(): array
    {
        return $this->only([
            'replay', 'image_id', 'user_id', 'message_id'
        ]);
    }
}
