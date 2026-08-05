<?php

use App\Http\Controllers\Admin\BlogPostController as AdminBlogPostController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\SystemController as AdminSystemController;
use App\Http\Controllers\Admin\TechnologyController as AdminTechnologyController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\SystemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Language negotiation
|--------------------------------------------------------------------------
|
| "/" serves no content — it negotiates. Arabic is listed first in
| config('site.locales'), so it is what a browser gets when it asks for
| anything we do not publish. A 302 (not 301) because the answer depends on
| the visitor, and a permanent redirect would pin the first answer in caches
| and in Google's index for everyone.
|
*/

Route::get('/', function (Request $request) {
    $locales = array_keys(config('site.locales'));

    return redirect()->to('/'.($request->getPreferredLanguage($locales) ?: config('app.locale')));
})->name('root');

// Not localized: one sitemap lists both language trees.
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

/*
|--------------------------------------------------------------------------
| Public routes (/ar/... and /en/...)
|--------------------------------------------------------------------------
|
| The {locale} prefix plus URL::defaults() in SetLocale means route('blog.index')
| keeps working everywhere and resolves to the language of the current page.
|
*/

Route::prefix('{locale}')->whereIn('locale', array_keys(config('site.locales')))->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Blog
    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/{post}', [BlogController::class, 'show'])->name('blog.show');

    // Projects
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');

    // Systems
    Route::get('/systems', [SystemController::class, 'index'])->name('systems.index');
    Route::get('/systems/{system}', [SystemController::class, 'show'])->name('systems.show');

    // Contact
    Route::get('/contact', [ContactController::class, 'show'])->name('contact');
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
});

/*
| The Technologies page listed frameworks and tooling — developer jargon that
| the audience explicitly does not buy on. Removed from the site; the URL is
| kept as a permanent redirect so existing links and any accrued ranking
| signal land on the homepage instead of a 404.
*/
Route::permanentRedirect('/technologies', '/');
Route::permanentRedirect('/{locale}/technologies', '/')->whereIn('locale', array_keys(config('site.locales')));

/*
| The site was previously unprefixed (/blog, /contact, ...). Those URLs may be
| indexed or linked, so they move permanently into the primary language rather
| than 404ing.
*/
foreach (['blog', 'projects', 'systems', 'contact'] as $path) {
    Route::permanentRedirect("/{$path}", '/'.config('app.locale')."/{$path}");
    Route::permanentRedirect("/{$path}/{rest}", '/'.config('app.locale')."/{$path}/{rest}")
        ->where('rest', '.*');
}

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Blog Posts CRUD
    Route::resource('blog-posts', AdminBlogPostController::class)->except(['show']);

    // Projects CRUD
    Route::resource('projects', AdminProjectController::class)->except(['show']);

    // Technologies CRUD
    Route::resource('technologies', AdminTechnologyController::class)->except(['show']);

    // Systems CRUD
    Route::resource('systems', AdminSystemController::class)->except(['show']);

    // Contact Messages
    Route::get('contacts', [AdminContactController::class, 'index'])->name('contacts.index');
    Route::get('contacts/{contact}', [AdminContactController::class, 'show'])->name('contacts.show');
    Route::delete('contacts/{contact}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');
});
