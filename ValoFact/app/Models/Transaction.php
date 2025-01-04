<?php

namespace App\Models;

use App\enums\PaymentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;


    protected $fillabe = [
        'amount',
        'status',
        'transaction_date'
    ];



    protected function casts() 
    {
        return [
            'amount' => 'decimal:2',
            'transaction_date' => 'datetime',
            'status' => PaymentStatus::class
        ];
    }
    








    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }



    public function bid(): BelongsTo
    {
        return $this->belongsTo(Bid::class);
    }
}
