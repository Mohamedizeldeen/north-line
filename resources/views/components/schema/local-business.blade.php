@php
    $site = config('site');

    $address = array_filter([
        '@type' => 'PostalAddress',
        'streetAddress' => $site['address']['street'],
        'addressLocality' => $site['address']['locality'],
        'addressRegion' => $site['address']['region'],
        'postalCode' => $site['address']['postal_code'],
        'addressCountry' => $site['address']['country'],
    ]);

    // Only emit geo/hours once real values exist in config/site.php.
    $geo = ($site['address']['latitude'] && $site['address']['longitude']) ? [
        '@type' => 'GeoCoordinates',
        'latitude' => $site['address']['latitude'],
        'longitude' => $site['address']['longitude'],
    ] : null;

    $hours = collect($site['opening_hours'])->map(fn ($range, $days) => [
        '@type' => 'OpeningHoursSpecification',
        'dayOfWeek' => $days,
        'opens' => $range[0],
        'closes' => $range[1],
    ])->values()->all();

    $schema = array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'ProfessionalService',
        '@id' => url('/') . '/#localbusiness',
        'name' => $site['legal_name'],
        'url' => url('/'),
        'image' => asset($site['og_image']),
        'logo' => asset($site['logo']),
        'email' => $site['email'],
        'telephone' => collect($site['phones'])->pluck('e164')->all(),
        'address' => $address,
        'geo' => $geo,
        'openingHoursSpecification' => $hours ?: null,
        'areaServed' => ['@type' => 'Country', 'name' => 'Oman'],
        'parentOrganization' => ['@id' => url('/') . '/#organization'],
    ]);
@endphp

<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
