<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use App\enums\OrderStatus;
use App\enums\QuantityUnit;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'title',
        'description',
        'quantity',
        'quantity_unit',
        'quality',
        'location',
        'include_transportation',
        'start_price',
        'start_date',
        'end_date',
        'status',
        'user_id'
    ];



    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:2',
            'quantity_unit' => QuantityUnit::class,
            'start_price' => 'decimal:2',
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'include_transportation' => 'boolean',
            'status' => OrderStatus::class,
            'created_at' => 'datetime'
        ];
    }
    



    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function medias(): HasMany
    {
        return $this->hasMany(OrderMedia::class);
    }


    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class);
    }


}
