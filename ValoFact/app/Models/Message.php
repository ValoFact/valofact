<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Message extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;



    protected $fillable = [
        'content',
        'read_at'
    ];


    protected function casts(): array
    {
        return [
            'read_at' => 'datetime',
        ];
    }




    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
