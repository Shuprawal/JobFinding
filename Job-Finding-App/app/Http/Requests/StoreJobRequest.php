<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobRequest extends FormRequest
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
            'title' => 'required|string|max:255',

            'description' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'company_id' => 'required|integer|exists:companies,id',
            'category_id' => 'required|integer|exists:categories,id',

            'salary' => 'required|integer|min:1|max:1000000000',
            'deadline' => 'required|date|after:today',
            'status'=> 'required|string|max:255',
            'type' => 'required|string|max:255',

        ];
    }
}
