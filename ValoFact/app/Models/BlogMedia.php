<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;


class BlogMedia extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'path'
    ];


    public function blogPost(): BelongsTo
    {
        return $this->belongsTo(BlogPost::class);
    }


    public function mediaUrl(): string
    {
        return Storage::url($this->path);
    }

}
