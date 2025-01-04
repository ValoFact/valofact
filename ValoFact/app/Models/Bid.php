<?php

namespace App\Models;

use App\enums\BidStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Bid extends Model
{

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;



    protected $fillable = [
        'amount',
        'status',
        'bid_time'
    ];



    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'bid_time' => 'datetime',
            'status' => BidStatus::class
        ];
    }



    


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
