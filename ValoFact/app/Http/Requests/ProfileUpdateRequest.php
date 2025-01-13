<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\enums\UserType;
use Illuminate\Validation\Rules\Enum;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3'],
            'email' => ['required', 'email', Rule::unique(User::class)->ignore($this->user()->id)], 
            'password' => ['required', 'min:4', 'confirmed'], 
            'type' => ['required', new Enum(UserType::class)], 
            'company_name' => ['string'], 
            'contact_information' => ['required', 'string'],
            'location' => ['required', 'string']            
            ];
    }
}
