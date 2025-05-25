<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobFilterRequest extends FormRequest
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
           'search' => 'string|max:255|nullable',
            'category_id' => 'integer|nullable|exists:categories,id',
            'company_id' => 'integer|nullable|exists:companies,id',
            'location' => 'string|max:255|nullable',
            'type' => ['nullable','in:full-time,part-time,internship'],
            'deadline' => 'date|nullable',
            'posted_date' => 'date|nullable',

        ];
    }
    public function withValidator($validator)
    {

        $validator ->after(function ($validator) {
            if ($this->input('deadline') && $this->input('posted_date')) {

                if ($this->input('posted_date') > $this->input('deadline')) {
                    $validator->errors()->add('deadline', 'Deadline must be greater than posted date');
                }
            }
        });
    }
}
