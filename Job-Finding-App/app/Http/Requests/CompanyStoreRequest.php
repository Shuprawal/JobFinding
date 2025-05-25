<?php

namespace App\Http\Requests;

use App\Models\Company;
use App\Models\Role;
use App\Models\User;
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

        $company=$this->route('company');
        $companyId=$company?->id;
        $user= $company?->user_id;
        return [
            'name' => ['required','string','max:255',
                Rule::unique(Company::class)->ignore($company)
                ],
            'email' => ['required','string','email','max:255',
                Rule::unique(Company::class)->ignore($companyId),
                Rule::unique(User::class)->ignore($user)
                ],
            'description' => 'required|string|max:255',
            'website' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'phone' => 'required|integer|min:1',
        ];
    }

}
