<?php

namespace App\Models;

use App\Models\Concerns\HasBilingualSlug;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogPost extends Model
{
    use HasFactory, HasBilingualSlug;

    protected $fillable = [
        'is_technical',
        'user_id',
        'title_ar',
        'title_en',
        'slug_ar',
        'slug_en',
        'excerpt_ar',
        'excerpt_en',
        'content_ar',
        'content_en',
        'featured_image',
        'is_published',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'is_technical' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    protected function title(): Attribute
    {
        return Attribute::make(get: fn () => $this->{'title_'.app()->getLocale()});
    }

    protected function slug(): Attribute
    {
        return Attribute::make(get: fn () => $this->{'slug_'.app()->getLocale()});
    }

    protected function excerpt(): Attribute
    {
        return Attribute::make(get: fn () => $this->{'excerpt_'.app()->getLocale()});
    }

    protected function content(): Attribute
    {
        return Attribute::make(get: fn () => $this->{'content_'.app()->getLocale()});
    }
}
