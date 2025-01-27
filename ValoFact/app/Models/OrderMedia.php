<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class OrderMedia extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'path',
        'order_id'
    ];


    
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }



    public function mediaUrl(): string
    {
        return Storage::url($this->path);
    }

}