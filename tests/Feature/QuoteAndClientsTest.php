<?php

use App\Models\Client;
use App\Models\QuoteRequest;

it('renders the quote request form', function () {
    $this->get('/ar/quote')->assertOk()->assertSee(__('quote.form.submit'));
    $this->get('/en/quote')->assertOk();
});

it('stores a valid quote request and redirects with success', function () {
    $response = $this->post('/ar/quote', [
        'name' => 'Sara',
        'company' => 'Gulf Retail',
        'email' => 'sara@example.com',
        'phone' => '+96890000000',
        'service' => 'Custom Software',
        'message' => 'We need an internal system.',
    ]);

    $response->assertRedirect(route('quote'))->assertSessionHas('success');

    expect(QuoteRequest::where('email', 'sara@example.com')->exists())->toBeTrue();
    expect(QuoteRequest::first()->status)->toBe('unread');
});

it('rejects a quote request without the required fields', function () {
    $this->post('/ar/quote', ['company' => 'X'])
        ->assertSessionHasErrors(['name', 'email']);

    expect(QuoteRequest::count())->toBe(0);
});

it('renders the clients page and lists only published clients', function () {
    Client::create(['name' => 'Visible Co', 'is_published' => true, 'sort_order' => 0]);
    Client::create(['name' => 'Hidden Co', 'is_published' => false, 'sort_order' => 1]);

    $this->get('/ar/clients')->assertOk()
        ->assertSee('Visible Co')
        ->assertDontSee('Hidden Co');
});

it('keeps the project page free of an external visit link', function () {
    $this->get('/en/projects/al-noor-medical-center')->assertOk()
        ->assertDontSee(__('work.visit'));
})->skip(fn () => ! \App\Models\Project::where('slug', 'al-noor-medical-center')->exists(), 'seed project missing');
