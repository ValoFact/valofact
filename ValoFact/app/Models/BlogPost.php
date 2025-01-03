<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class BlogPost extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'title',
        'content',
        'published_at'
    ];


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime'
        ];
    }




    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }



    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class);
    }



    public function blogMedias(): HasMany
    {
        return $this->hasMany(BlogMedia::class);
    }


    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
