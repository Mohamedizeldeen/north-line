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
    | language switcher. Arabic is primary and is listed first.
    |

    | Order matters: the first entry is the Accept-Language fallback when a
    | visitor's browser asks for a language we do not publish.
    */

    'locales' => [
        'ar' => ['name' => 'العربية', 'hreflang' => 'ar', 'dir' => 'rtl'],
        'en' => ['name' => 'English', 'hreflang' => 'en', 'dir' => 'ltr'],
    ],

    // hreflang="x-default" points at the redirecting root, which is what
    // Google recommends when "/" negotiates language rather than serving a page.
    'x_default_locale' => null,

];
