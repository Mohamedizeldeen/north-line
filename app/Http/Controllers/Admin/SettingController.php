<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /** The settings this form manages, with their config() fallback. */
    private function fields(): array
    {
        return [
            'email' => config('site.email'),
            'phone_display' => config('site.phones.0.display'),
            'phone_e164' => config('site.phones.0.e164'),
            'address_street' => config('site.address.street'),
            'address_locality' => config('site.address.locality'),
            'address_region' => config('site.address.region'),
            'address_postal_code' => config('site.address.postal_code'),
            'address_country' => config('site.address.country'),
            'social_instagram' => null,
            'social_x' => null,
            'social_linkedin' => null,
            'social_whatsapp' => null,
        ];
    }

    public function edit()
    {
        $stored = Setting::allValues();
        $settings = [];

        foreach ($this->fields() as $key => $fallback) {
            $settings[$key] = $stored[$key] ?? $fallback;
        }

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'email' => 'nullable|email|max:255',
            'phone_display' => 'nullable|string|max:50',
            'phone_e164' => 'nullable|string|max:50',
            'address_street' => 'nullable|string|max:255',
            'address_locality' => 'nullable|string|max:255',
            'address_region' => 'nullable|string|max:255',
            'address_postal_code' => 'nullable|string|max:50',
            'address_country' => 'nullable|string|max:10',
            'social_instagram' => 'nullable|url|max:255',
            'social_x' => 'nullable|url|max:255',
            'social_linkedin' => 'nullable|url|max:255',
            'social_whatsapp' => 'nullable|url|max:255',
        ]);

        foreach (array_keys($this->fields()) as $key) {
            Setting::put($key, $validated[$key] ?? null);
        }

        return redirect()->route('admin.settings.edit')->with('success', 'Settings saved successfully.');
    }
}
