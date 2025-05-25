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
        if ($this->isMethod('patch')){
            return [
                'type' => ['required','in:full-time,part-time,internship'],
            ];
        }
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'category_id' => 'integer|exists:categories,id|required_without:category_name',
            'category_name' => 'string|max:255|required_without:category_id',
            'salary' => 'required|integer|min:1|max:1000000000',
            'deadline' => 'required|date|after:today',
            'type' => ['required','in:full-time,part-time,internship'],

        ];
    }
}
