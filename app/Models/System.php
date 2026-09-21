<?php

namespace App\Models;

use App\Models\Concerns\HasBilingualSlug;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    use HasFactory, HasBilingualSlug;

    protected $fillable = [
        'title_ar',
        'title_en',
        'slug_ar',
        'slug_en',
        'description_ar',
        'description_en',
        'content_ar',
        'content_en',
        'image',
        'video_url',
        'video_path',
        'demo_url',
        'is_published',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    protected function title(): Attribute
    {
        return Attribute::make(get: fn () => $this->{'title_'.app()->getLocale()});
    }

    protected function slug(): Attribute
    {
        return Attribute::make(get: fn () => $this->{'slug_'.app()->getLocale()});
    }

    protected function description(): Attribute
    {
        return Attribute::make(get: fn () => $this->{'description_'.app()->getLocale()});
    }

    protected function content(): Attribute
    {
        return Attribute::make(get: fn () => $this->{'content_'.app()->getLocale()});
    }
}
