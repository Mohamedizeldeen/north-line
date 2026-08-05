<?php

use App\Models\BlogPost;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| SEO foundation (PHASE 2)
|--------------------------------------------------------------------------
|
| These lock the rules the SEO layer is built on. PHASE 3 adds the Arabic
| locale and will touch every one of these files — if a title runs long, a
| canonical starts pointing at the other language, or a JSON-LD block breaks,
| these fail rather than shipping silently.
|
*/

/** Pages whose copy is authored in lang/{locale}/seo.php. */
function authoredPages(): array
{
    return ['/', '/blog', '/projects', '/systems', '/technologies', '/contact'];
}

function metaContent(string $html, string $pattern): ?string
{
    return preg_match($pattern, $html, $m) ? html_entity_decode($m[1], ENT_QUOTES) : null;
}

function jsonLdBlocks(string $html): array
{
    preg_match_all('#<script type="application/ld\+json">(.*?)</script>#s', $html, $m);

    return $m[1];
}

it('keeps every page title within 60 characters', function (string $uri) {
    $html = $this->get($uri)->assertOk()->getContent();
    $title = metaContent($html, '#<title>(.*?)</title>#s');

    expect($title)->not->toBeNull()
        ->and(mb_strlen($title))->toBeLessThanOrEqual(60);
})->with(authoredPages());

it('gives every authored page a 150-160 character description', function (string $uri) {
    $html = $this->get($uri)->assertOk()->getContent();
    $description = metaContent($html, '#<meta name="description" content="(.*?)">#s');

    expect(mb_strlen($description))->toBeGreaterThanOrEqual(150)
        ->and(mb_strlen($description))->toBeLessThanOrEqual(160);
})->with(authoredPages());

it('renders exactly one h1 per page', function (string $uri) {
    $html = $this->get($uri)->assertOk()->getContent();

    expect(preg_match_all('/<h1[\s>]/', $html))->toBe(1);
})->with([...authoredPages(), '/login']);

it('gives every page a description that is unique across the site', function () {
    $descriptions = collect(authoredPages())->map(
        fn ($uri) => metaContent($this->get($uri)->getContent(), '#<meta name="description" content="(.*?)">#s')
    );

    expect($descriptions->unique())->toHaveCount($descriptions->count());
});

it('self-references its canonical and never points at another URL', function (string $uri) {
    $html = $this->get($uri)->assertOk()->getContent();
    $canonical = metaContent($html, '#<link rel="canonical" href="(.*?)">#');

    expect($canonical)->toBe(url($uri === '/' ? '' : $uri));
})->with(authoredPages());

it('marks the login page noindex', function () {
    expect($this->get('/login')->getContent())
        ->toContain('<meta name="robots" content="noindex, follow">');
});

it('marks content pages indexable', function (string $uri) {
    expect($this->get($uri)->getContent())->toContain('name="robots" content="index, follow');
})->with(authoredPages());

it('emits only valid JSON-LD', function (string $uri) {
    $blocks = jsonLdBlocks($this->get($uri)->assertOk()->getContent());

    expect($blocks)->not->toBeEmpty();

    foreach ($blocks as $block) {
        $decoded = json_decode($block, true);
        expect(json_last_error())->toBe(JSON_ERROR_NONE)
            ->and($decoded)->toHaveKeys(['@context', '@type']);
    }
})->with([...authoredPages(), '/login']);

it('puts the Organization entity on every page', function (string $uri) {
    $types = collect(jsonLdBlocks($this->get($uri)->getContent()))
        ->map(fn ($b) => json_decode($b, true)['@type']);

    expect($types)->toContain('Organization');
})->with([...authoredPages(), '/login']);

it('only marks up FAQ questions that are visible on the page', function () {
    $html = $this->get('/contact')->assertOk()->getContent();

    $faq = collect(jsonLdBlocks($html))
        ->map(fn ($b) => json_decode($b, true))
        ->firstWhere('@type', 'FAQPage');

    expect($faq)->not->toBeNull();

    foreach ($faq['mainEntity'] as $question) {
        expect($html)->toContain(e($question['name']));
    }
});

it('serves a valid sitemap covering published content', function () {
    $post = BlogPost::create([
        'user_id' => User::create([
            'name' => 'Test Author', 'email' => 'a@example.com', 'password' => 'secret',
        ])->id,
        'title' => 'Indexable Post',
        'slug' => 'indexable-post',
        'content' => 'Body copy.',
        'is_published' => true,
        'published_at' => now()->subDay(),
    ]);

    $xml = $this->get('/sitemap.xml')
        ->assertOk()
        ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
        ->getContent();

    expect(simplexml_load_string($xml))->not->toBeFalse()
        ->and($xml)->toContain(route('blog.show', $post))
        ->and($xml)->toContain(route('home'))
        ->and($xml)->toContain(route('contact'));
});

it('leaves the sitemap free of unpublished content', function () {
    $draft = BlogPost::create([
        'user_id' => User::create([
            'name' => 'Draft Author', 'email' => 'draft@example.com', 'password' => 'secret',
        ])->id,
        'title' => 'Draft Post', 'slug' => 'draft-post', 'content' => 'x', 'is_published' => false,
    ]);

    expect($this->get('/sitemap.xml')->getContent())
        ->not->toContain(route('blog.show', $draft));
});

it('does not block AI assistants in robots.txt', function () {
    $robots = file_get_contents(public_path('robots.txt'));

    foreach (['GPTBot', 'ClaudeBot', 'PerplexityBot', 'Google-Extended'] as $bot) {
        // A named group would override the wildcard group; none should exist.
        expect($robots)->not->toMatch("/^User-agent:\s*{$bot}/mi");
    }

    expect($robots)->toMatch('/^User-agent:\s*\*/m')
        ->and($robots)->not->toMatch('/^Disallow:\s*\/\s*$/m')
        ->and($robots)->toContain('Sitemap: ');
});
