<?php

namespace App\Http\Requests;

use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyStoreRequest extends FormRequest
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
        $company= $this->route('company')?->id;
        return [
            'name' => ['required','string','max:255',
                Rule::unique(Company::class)->ignore($company)
                ],
            'description' => 'required|string|max:255',
            'website' => 'required|string|max:255',
        ];
    }

}
