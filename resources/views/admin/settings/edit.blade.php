@extends('layouts.admin')
@section('page-title', 'Site Settings')

@section('content')
<div class="max-w-2xl">
    <h2 class="text-xl font-bold mb-1">Site Settings</h2>
    <p class="text-sm text-gray-400 mb-6">These feed the footer, contact page and the site's structured data (Organization / LocalBusiness).</p>

    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
        @csrf @method('PUT')

        <div class="bg-gray-900 rounded-xl border border-gray-800 p-5 space-y-4">
            <h3 class="font-semibold text-gray-200">Contact</h3>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $settings['email']) }}" dir="ltr"
                       class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                @error('email') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Phone (display)</label>
                    <input type="text" name="phone_display" value="{{ old('phone_display', $settings['phone_display']) }}" dir="ltr" placeholder="+968 9808 4952"
                           class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Phone (E.164)</label>
                    <input type="text" name="phone_e164" value="{{ old('phone_e164', $settings['phone_e164']) }}" dir="ltr" placeholder="+96898084952"
                           class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                </div>
            </div>
        </div>

        <div class="bg-gray-900 rounded-xl border border-gray-800 p-5 space-y-4">
            <h3 class="font-semibold text-gray-200">Address</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach(['address_street'=>'Street','address_locality'=>'Locality','address_region'=>'Region','address_postal_code'=>'Postal code','address_country'=>'Country (code)'] as $key => $label)
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">{{ $label }}</label>
                        <input type="text" name="{{ $key }}" value="{{ old($key, $settings[$key]) }}"
                               class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        @error($key) <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-gray-900 rounded-xl border border-gray-800 p-5 space-y-4">
            <h3 class="font-semibold text-gray-200">Social links</h3>
            @foreach(['social_instagram'=>'Instagram','social_x'=>'X (Twitter)','social_linkedin'=>'LinkedIn','social_whatsapp'=>'WhatsApp'] as $key => $label)
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">{{ $label }}</label>
                    <input type="url" name="{{ $key }}" value="{{ old($key, $settings[$key]) }}" dir="ltr" placeholder="https://…"
                           class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    @error($key) <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            @endforeach
        </div>

        <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition">Save Settings</button>
    </form>
</div>
@endsection
