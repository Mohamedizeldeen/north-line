<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Business identity (NAP)
    |--------------------------------------------------------------------------
    |
    | Single source of truth for Name / Address / Phone. The visible footer and
    | the JSON-LD both read from here. Google treats structured data that
    | contradicts the visible page as a violation, so never hardcode these in a
    | Blade view again — change them here.
    |
    */

    'name' => 'North Line',
    'legal_name' => 'North Line Development',

    'email' => 'info@northline-dev.com',

    // E.164 for schema.org, plus the human form shown in the footer.
    'phones' => [
        ['e164' => '+96898084952', 'display' => '(+968) 9808-4952'],
        ['e164' => '+96899822690', 'display' => '(+968) 9982-2690'],
    ],

    'address' => [
        'locality' => 'Al Khoud',
        'region' => 'Muscat',
        'country' => 'OM',

        // Not emitted in JSON-LD until real values are supplied — inventing a
        // street, postcode or coordinates is a manual-action risk.
        'street' => null,
        'postal_code' => null,
        'latitude' => null,
        'longitude' => null,
    ],

    // Business hours, once known: ['Mo-Th' => ['08:00', '17:00'], ...]
    'opening_hours' => [],

    // Public social profiles → schema.org sameAs. Empty until supplied.
    'social' => [],

    /*
    |--------------------------------------------------------------------------
    | Social sharing defaults
    |--------------------------------------------------------------------------
    */

    'og_image' => 'images/logo.png',
    'logo' => 'images/logo.png',

    /*
    |--------------------------------------------------------------------------
    | Locales
    |--------------------------------------------------------------------------
    |
    | Drives the <html lang>/dir attributes, the hreflang alternates and the
    | language switcher. PHASE 3 adds the 'ar' entry and the /{locale} route
    | prefix; every consumer below already loops this list, so hreflang starts
    | emitting reciprocal pairs the moment that entry appears.
    |
    */

    'locales' => [
        'en' => ['name' => 'English', 'hreflang' => 'en', 'dir' => 'ltr'],
    ],

    // hreflang="x-default" target. PHASE 3 points this at the redirecting root.
    'x_default_locale' => 'en',

];
