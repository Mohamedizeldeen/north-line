<?php

namespace App\Models;

use App\Models\Concerns\HasLocale;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasLocale;

    protected $fillable = [
        'locale',
        'translation_group_id',
        'question',
        'answer',
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
}
