<?php

namespace App\Http\Requests;

use App\enums\UserType;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UserFormRequest extends FormRequest
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
            'name' => ['required', ],
            'email' => ['required', 'email', Rule::unique(User::class)], 
            'password' => ['required', 'min:4', 'confirmed'], 
            'type' => ['required', new Enum(UserType::class)], 
            'company_name' => ['string'], 
            'contact_information' => ['required', 'string'],
            'location' => ['required', 'string']
        ];
    }
}
