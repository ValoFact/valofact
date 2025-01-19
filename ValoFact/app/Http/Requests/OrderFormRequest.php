<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rule;
use App\enums\OrderStatus;
use App\enums\QuantityUnit;
use App\Models\ItemCategory;
use App\Models\Order;

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
        $itemCategories = ItemCategory::pluck('id')->toArray();
        $quantityUnits = [QuantityUnit::KG->value, QuantityUnit::TON->value];
        $orderStatus = [OrderStatus::AVAILABLE->value, OrderStatus::SOLD->value, OrderStatus::EXPIRED->value];

        return [
            'title' => ['required', 'string', 'min:3', Rule::unique(Order::class)],
            'description' => ['nullable', 'string'],
            'quantity' => ['required', 'numeric', 'gte:0'],
            'calculated_quantity' => ['required', 'numeric', 'gte:0'],
            'quantity_unit' => ['required', 'in:' . implode(',', $quantityUnits)],
            'quality' => ['nullable', 'string'],
            'location' => ['required', 'string'],
            'include_transportation' => ['required', 'boolean'],
            'start_price' => ['required', 'numeric'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'status' => ['required', 'string', 'in:' . implode(',', $orderStatus)],
            // Items (array validation)
            'items' => ['required','array'],
            'items.*.name' => ['required', 'string', 'min:2', 'max:255'],
            'items.*.quantity' => ['required', 'numeric', 'min:0'],
            'items.*.quantity_unit' => ['required', 'in:' . implode(',', $quantityUnits)],
            'items.*.unit_price' => ['nullable', 'numeric', 'min:0'],
            'items.*.item_category_id' => ['required', 'in:' . implode(',', $itemCategories)],
            //Media (array validation)
            'medias' => ['nullable', 'array'],
            'medias.*.file' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,mp4,mov,avi', 'max:20480']            
        ];
    }
}
