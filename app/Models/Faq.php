<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'question_ar',
        'question_en',
        'answer_ar',
        'answer_en',
        'sort_order',
        'is_published',
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

    public function scopeAvailableIn($query, ?string $locale = null)
    {
        return $query->whereNotNull('question_'.($locale ?? app()->getLocale()));
    }

    protected function question(): Attribute
    {
        return Attribute::make(get: fn () => $this->{'question_'.app()->getLocale()});
    }

    protected function answer(): Attribute
    {
        return Attribute::make(get: fn () => $this->{'answer_'.app()->getLocale()});
    }
}
