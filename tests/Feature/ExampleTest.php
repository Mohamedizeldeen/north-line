<?php

test('the root path negotiates a language instead of serving a page', function () {
    // Symfony's test client always sends Accept-Language: en-us,en;q=0.5, so
    // the header is set explicitly here rather than relying on its absence.
    $this->get('/', ['Accept-Language' => 'ar-OM,ar;q=0.9'])
        ->assertStatus(302)
        ->assertRedirect('/ar');

    $this->get('/', ['Accept-Language' => 'en-GB,en;q=0.9'])
        ->assertStatus(302)
        ->assertRedirect('/en');
});

test('the primary language homepage renders', function () {
    $this->get('/ar')->assertOk();
});

test('the secondary language homepage renders', function () {
    $this->get('/en')->assertOk();
});
