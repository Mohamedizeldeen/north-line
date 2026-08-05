<?php

/*
|--------------------------------------------------------------------------
| Per-page SEO copy
|--------------------------------------------------------------------------
|
| Consumed by <x-seo page="..."/>. Rules enforced by tests/Feature/SeoTest.php:
|   - title:       <= 60 characters
|   - description: 150-160 characters, with a value proposition and a
|                  location signal ("Oman" / "Muscat")
|
| PHASE 3 adds lang/ar/seo.php with the same keys. Do not hardcode any of this
| copy back into a Blade view — the Arabic build reads these keys.
|
*/

return [

    'home' => [
        'title' => 'Fashion Store Systems in Oman — POS & Online Store',
        'description' => 'North Line builds the complete system for fashion stores in Oman: one online store, one point of sale, and one shared inventory across all your branches.',
    ],

    'blog' => [
        'title' => 'Blog — Retail Technology Advice for Omani Stores',
        'description' => 'Practical guides on running a fashion store in Oman: online stores, point of sale, stock control, payments and accounting, written for shop owners in Muscat.',
    ],

    'projects' => [
        'title' => 'Our Projects — Software Built in Muscat, Oman',
        'description' => 'Selected work from North Line: online stores, point-of-sale systems and business platforms we have delivered for clients across Muscat and the rest of Oman.',
    ],

    'systems' => [
        'title' => 'Ready-Made Business Systems for Omani Companies',
        'description' => 'Ready-to-run systems from North Line in Muscat: online store, point of sale, unified inventory, accounting and email marketing, built for Omani businesses.',
    ],

    'technologies' => [
        'title' => 'How We Build — The Technology Behind North Line',
        'description' => 'How North Line builds reliable retail and business systems in Oman, and the proven tools we rely on to keep your store selling every day without downtime.',
    ],

    'contact' => [
        'title' => 'Contact North Line — Software Company in Muscat',
        'description' => 'Talk to North Line in Al Khoud, Muscat about an online store, point of sale or unified inventory for your shop in Oman. We reply to you within 24 hours.',
    ],

    'login' => [
        'title' => 'Sign In',
        'description' => 'Sign in to the North Line administration area.',
    ],

    /*
    | Fallbacks for dynamic detail pages (blog posts, projects, systems). The
    | page's own title/description win; these only fill gaps.
    */
    'defaults' => [
        'title' => 'North Line — Fashion Retail Systems in Oman',
        'description' => 'North Line builds online stores, point-of-sale systems and unified inventory for fashion retail and growing businesses across Muscat and Oman. Talk to us today.',
    ],

    'suffix' => ' | North Line',

];
