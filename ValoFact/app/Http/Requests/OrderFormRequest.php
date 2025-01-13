<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\enums\OrderStatus;
use App\enums\QuantityUnit;

class OrderFormRequest extends FormRequest
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
            'title' => ['required', 'string'],
            'description' => ['required', 'text'],
            'quantity' => ['required', 'decimal'],
            'quantity_unit' => ['required', 'string', new Enum(QuantityUnit::class)],
            'quality' => ['string'],
            'items' => ['array', 'exists:items,id', 'required'],
            'location' => ['required', 'string'],
            'include_transportation' => ['required', 'boolean'],
            'start_price' => ['required', 'decimal'],
            'start_date' => ['required', 'datetime'],
            'end_date' => ['required', 'datetime'],
            'status' => ['required', 'string', new Enum(OrderStatus::class)]            
        ];
    }
}
