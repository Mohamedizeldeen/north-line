<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class Translation extends Model
{
    protected $fillable = ['locale', 'group', 'item', 'value'];

    /**
     * Every override, indexed as ["{locale}.{group}"][item] => value, cached.
     * The database translation loader reads this once per process.
     */
    public static function overrides(): array
    {
        if (! Schema::hasTable('translations')) {
            return [];
        }

        return Cache::rememberForever('translations.overrides', function () {
            $map = [];

            foreach (static::all(['locale', 'group', 'item', 'value']) as $row) {
                $map["{$row->locale}.{$row->group}"][$row->item] = $row->value;
            }

            return $map;
        });
    }

    public static function flush(): void
    {
        Cache::forget('translations.overrides');
    }

    protected static function booted(): void
    {
        static::saved(fn () => static::flush());
        static::deleted(fn () => static::flush());
    }
}
