<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'first_name' => ['required','string','max:255','regex:/^[a-zA-Z]+$/u'],
            'last_name' => ['required','string','max:255','regex:/^[a-zA-Z]+$/u'],
            'email' => ['required','string','email','max:255','unique:users,email'],
            'password' => ['required','string','min:8','confirmed'],
            'phone' => ['required','string','max:255','min:1'],
            'username' => ['required','string','max:255','min:3','unique:users,username'],

        ];
    }
}
