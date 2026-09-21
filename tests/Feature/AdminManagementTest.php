<?php

use App\Models\Faq;
use App\Models\Setting;
use App\Models\Translation;
use App\Models\User;

function admin(): User
{
    return User::create([
        'name' => 'Admin', 'email' => 'admin@test.dev', 'password' => 'password', 'is_admin' => true,
    ]);
}

it('gates the admin area to admins', function () {
    $this->get('/admin')->assertRedirect(); // guests bounce to login
    $this->actingAs(admin())->get('/admin')->assertOk();
});

it('creates and manages users', function () {
    $this->actingAs(admin())->post('/admin/users', [
        'name' => 'Editor', 'email' => 'editor@test.dev',
        'password' => 'secret123', 'password_confirmation' => 'secret123', 'is_admin' => '1',
    ])->assertRedirect('/admin/users');

    expect(User::where('email', 'editor@test.dev')->exists())->toBeTrue();
});

it('stops an admin from deleting their own account', function () {
    $me = admin();
    $this->actingAs($me)->delete("/admin/users/{$me->id}")->assertSessionHas('error');
    expect(User::find($me->id))->not->toBeNull();
});

it('saves a site setting and overlays it onto config on boot', function () {
    $this->actingAs(admin())->put('/admin/settings', [
        'email' => 'new@northline-dev.com',
    ])->assertRedirect();

    expect(Setting::allValues()['email'])->toBe('new@northline-dev.com');

    // Each real request is a fresh boot; simulate that boot here.
    (new App\Providers\AppServiceProvider($this->app))->boot();
    expect(config('site.email'))->toBe('new@northline-dev.com');
});

it('lets an admin-managed translation override the page copy', function () {
    Translation::create(['locale' => 'ar', 'group' => 'seo', 'item' => 'home.title', 'value' => 'عنوان مخصص للاختبار']);
    Translation::flush();

    $this->get('/ar')->assertOk()->assertSee('عنوان مخصص للاختبار', false);
});

it('renders DB faqs over the lang-file defaults on the contact page', function () {
    Faq::create(['question_ar' => 'سؤال مخصص جداً', 'answer_ar' => 'جواب مخصص', 'is_published' => true, 'sort_order' => 0]);

    $this->get('/ar/contact')->assertOk()->assertSee('سؤال مخصص جداً', false);
});
