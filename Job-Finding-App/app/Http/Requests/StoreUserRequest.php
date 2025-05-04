<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user= $this->route('user')?->id;
        return [
            'first_name' => ['required','string','max:255','regex:/^[a-zA-Z]+$/u'],
            'last_name' => ['required','string','max:255','regex:/^[a-zA-Z]+$/u'],
            'email' => ['required','string','email','max:255',
                Rule::unique(User::class)->ignore($user)
                ],
            'password' => ['required','string','min:8','confirmed'],
            'phone' => ['required','string','max:255','min:1'],
            'username' => ['required','string','max:255','min:3',
                Rule::unique(User::class)->ignore($user)
                ],

        ];
    }
}
