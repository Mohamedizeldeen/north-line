<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    public $timestamps = true;

    /** All settings as a key => value map, cached. */
    public static function allValues(): array
    {
        if (! Schema::hasTable('settings')) {
            return [];
        }

        return Cache::rememberForever('settings.all', fn () => static::pluck('value', 'key')->all());
    }

    public static function put(string $key, ?string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('settings.all');
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('settings.all'));
        static::deleted(fn () => Cache::forget('settings.all'));
    }
}
