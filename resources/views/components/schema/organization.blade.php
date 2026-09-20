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

    $schema = array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        '@id' => url('/') . '/#organization',
        'name' => $site['legal_name'],
        'alternateName' => $site['name'],
        'url' => url('/'),
        'logo' => [
            '@type' => 'ImageObject',
            'url' => asset($site['logo']),
        ],
        'image' => asset($site['og_image']),
        'email' => $site['email'],
        'telephone' => collect($site['phones'])->pluck('e164')->all(),
        'address' => $address,
        'areaServed' => ['@type' => 'Country', 'name' => 'Oman'],
        'contactPoint' => [array_filter([
            '@type' => 'ContactPoint',
            'contactType' => 'sales',
            'telephone' => $site['phones'][0]['e164'] ?? null,
            'email' => $site['email'],
            'areaServed' => 'OM',
            'availableLanguage' => collect($site['locales'])
                ->map(fn ($l) => $l['name'])->values()->all(),
        ])],
        // Omitted entirely while empty — an empty sameAs is worse than none.
        'sameAs' => $site['social'] ?: null,
    ]);
@endphp

<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
