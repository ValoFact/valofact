<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Models\ItemCategory;
use App\enums\OrderStatus;

class OrdersFiltersRequest extends FormRequest
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
        $itemCategories = ItemCategory::pluck('id')->toArray();
        $orderStatus = [OrderStatus::AVAILABLE->value, OrderStatus::SOLD->value, OrderStatus::EXPIRED->value];

        return [
            'title' => ['string', 'nullable'],
            'item_category_id' => ['in:' . implode(',', $itemCategories), 'nullable'],
            'quantiy<' => ['numeric', 'gte:0', 'nullable'],
            'quantiy>' => ['numeric', 'gte:0', 'nullable'],
            'location' => ['string', 'nullable'],
            'include_transportation' => ['boolean', 'nullable'],
            'status' => ['string', 'in:' . implode(',', $orderStatus), 'nullable']
        ];
    }
}
