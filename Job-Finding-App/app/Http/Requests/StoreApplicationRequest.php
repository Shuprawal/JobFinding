<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreApplicationRequest extends FormRequest
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

            'job_id' => ['required','integer','exists:jobs,id',

                Rule::unique('applications')->where(function ($query) {
                    return $query->where('user_id', auth()->id())->where('job_id', $this->job_id);
                })

            ],
            'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'cover_letter' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'job_id.unique' => 'You have already applied for this job',
        ];
    }

    protected function prepareForValidation()
    {

        $this->merge([
            'user_id' => auth()->id(),
        ]);
    }
}
