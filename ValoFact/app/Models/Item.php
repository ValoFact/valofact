<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use App\enums\QuantityUnit;

class Item extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;



    protected $fillable = [
        'name',
        'quantity',
        'quantity_unit',            // quantity unit = kg, ton ...
        'unit_price',               // unit price per kg/ton  
    ];


    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:2',
            'quantity_unit' => QuantityUnit::class,
            'unit_price' => 'decimal:2'
        ];
    }




    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }



    public function itemCategory(): BelongsTo
    {
        return $this->belongsTo(ItemCategory::class);
    }
}
