<?php

namespace App\Providers;

use App\Models\Setting;
use App\Translation\DatabaseTranslationLoader;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Overlay admin-edited translations on top of the lang/** files.
        $this->app->extend('translation.loader', function ($loader) {
            return new DatabaseTranslationLoader($loader);
        });
    }

    public function boot(): void
    {
        $this->overlaySettings();
    }

    /**
     * Let admin-managed settings override config('site.*') so existing
     * config() calls (schema, footer, contact) pick up the edited values.
     */
    private function overlaySettings(): void
    {
        $s = Setting::allValues();

        if (empty($s)) {
            return;
        }

        if (! empty($s['email'])) {
            config(['site.email' => $s['email']]);
        }

        if (! empty($s['phone_e164'])) {
            config(['site.phones' => [[
                'display' => $s['phone_display'] ?? $s['phone_e164'],
                'e164' => $s['phone_e164'],
            ]]]);
        }

        foreach (['street', 'locality', 'region', 'postal_code', 'country'] as $part) {
            if (isset($s["address_{$part}"]) && $s["address_{$part}"] !== '') {
                config(["site.address.{$part}" => $s["address_{$part}"]]);
            }
        }

        $social = array_values(array_filter([
            $s['social_instagram'] ?? null,
            $s['social_x'] ?? null,
            $s['social_linkedin'] ?? null,
            $s['social_whatsapp'] ?? null,
        ]));

        if ($social) {
            config(['site.social' => $social]);
        }
    }
}
