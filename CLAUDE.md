# North Line Development — Website

## About this project

North Line Development is an Omani software company based in Al Khoud, Muscat.
5+ years in business, 50+ projects, 30+ clients across multiple sectors —
healthcare, education, real estate, retail, and fashion (including the Muscat
Fashion Week website) among others.

North Line is a **full-service digital transformation consultancy** for
businesses in **Oman and the wider Gulf (GCC)**: we take a company from a
digital assessment through strategy, custom software, automation, integration,
and ongoing support — one team for every stage, not a single point product.
Muscat is home base; the audience is regional.

### Positioning

- **AR:** من التقييم الرقمي إلى الدعم المستمر — شريكك الكامل للتحول الرقمي في عُمان ودول الخليج
- **EN:** From digital assessment to ongoing support — your complete digital transformation partner in Oman and the Gulf.

### Service areas (all offered — seeded in `database/seeders/ServiceSeeder.php`)

| Area | What we provide |
| --- | --- |
| Digital Assessment | Analyze current systems, processes, problems, and gaps |
| Strategy & Roadmap | Decide what should be digitized and in what order |
| Custom Software | ERP, CRM, portals, mobile apps, internal systems |
| Process Automation | Replace Excel, paper, WhatsApp/manual workflows with automated processes |
| System Integration | Connect ERP, CRM, payment gateways, websites, APIs, etc. |
| Cloud Transformation | Move systems/infrastructure to cloud and modernize architecture |
| Data & BI | Dashboards, reports, analytics, centralized data |
| AI & Automation | AI assistants, document processing, intelligent workflows, RAG, forecasting |
| Cybersecurity & Governance | Security assessment, access control, policies, compliance |
| Training & Change Management | Train employees and help them adopt the new systems |
| Ongoing Support | Monitoring, optimization, maintenance and further transformation |

### Target customer

Businesses across Oman and the Gulf (GCC) — small and mid-size companies in
many sectors — that need to digitize or modernize how they operate. The
decision maker is typically a business owner, operations manager, or IT lead.
She or he buys primarily in **Arabic**, though many decision-makers are
comfortable in English too. Keep the copy Gulf-wide (عُمان ودول الخليج), with
Muscat as the stated home base rather than the whole market.

### Core pain we solve

Disconnected systems and data silos (every department on its own tool),
manual processes running on Excel/paper/WhatsApp instead of automation, and
no centralized reporting or real-time visibility into the business.

## Hard constraints

- **Arabic is the PRIMARY language**, English is secondary.
- Proper **RTL** support throughout.
- Copy targets **business decision-makers, not developers** — avoid
  engineering/implementation jargon (Laravel, API, framework, stack,
  endpoint) in customer-facing copy. Business/service terms (ERP, CRM,
  cloud, cybersecurity, automation) are fine — they are the actual named
  services this company sells.
- **Mobile-first**: a meaningful share of traffic arrives from mobile and
  from social channels.

## Arabic SEO targets

- برنامج تحول رقمي عمان
- أنظمة ERP للشركات العمانية
- أتمتة العمليات
- تكامل الأنظمة
- حلول ذكاء اصطناعي للشركات
- شركة برمجيات في مسقط

## Site status

The Arabic-primary bilingual foundation is built and tested
(`tests/Feature/SeoTest.php`): `/ar/` and `/en/` routing, root negotiation by
`Accept-Language` defaulting to Arabic, full RTL (`dir="rtl"`, mirrored
spacing, flipped directional icons), reciprocal self-referencing hreflang
with `x-default`, per-page canonical, per-page SEO titles/descriptions
(60 / 150–160 chars), and JSON-LD (`Organization` sitewide, `LocalBusiness`
on the homepage, `FAQPage` on contact, `BreadcrumbList` on inner pages).
`robots.txt` allows GPTBot, ClaudeBot, PerplexityBot, and Google-Extended;
`sitemap.xml` covers every published page.

Content architecture: translated content lives in `lang/ar/*.php` and
`lang/en/*.php` (one file per page/section); the services catalog lives in
the `System` model (bilingual rows paired by `translation_group_id`, seeded
by `database/seeders/ServiceSeeder.php`), rendered at `/ar/systems` and
`/en/systems` (nav label "خدماتنا" / "Services"). The `Project` portfolio and
blog posts are DB-driven the same way.

Additional admin-managed content (all editable under `/admin`):

- **Clients / "partners of success"** — the `Client` model (non-translated:
  name, logo, url, sort_order, is_published). Shown as a homepage strip and a
  standalone `/{locale}/clients` page. Logos render inside always-white tiles
  (`<x-client-logo>`) so any brand colour stays legible on both themes.
- **Videos on projects & systems** — each has `video_url` (external
  YouTube/Vimeo/direct link) and `video_path` (uploaded MP4/WebM on the public
  disk). Rendered by `<x-media-video>`, which prefers the uploaded file, else
  embeds via the `video_embed_url()` helper (`app/helpers.php`), else a native
  `<video>`. Project pages intentionally show **no external "visit" link** —
  cover image + video only.
- **Quote requests** — the `QuoteRequest` model + `/{locale}/quote` form
  (name/company/email/phone/service/message), saved and shown in `/admin`
  exactly like contact messages (unread badge, dashboard count). The nav CTA
  ("اطلب عرضاً") and each service page's "اطلب عرض السعر" button point here.
  There is deliberately no public pricing page with numbers.

## Design system

The look is a **premium dark theme by default** (deep near-black ground, a
controlled brand-hued aurora glow + faint grid behind the hero, vivid blue
accent, real depth) — inspired by laravel.com/cloud, **not** glassmorphism.
Do not reintroduce frosted-glass/`backdrop-filter` surfaces or pastel
gradient blobs; they read as generic AI output and were explicitly rejected.

- **Everything is centralized in `resources/css/app.css`.** Surfaces use
  token-driven `@utility glass-*` classes (the name is legacy — they are
  solid, not frosted). Light is the CSS base; the dark theme is one block of
  token overrides under `[data-theme="dark"]`, plus remaps of the exact
  `text-slate-*` / `text-blue-*` / `bg-white/*` utilities the templates use,
  so pages need no per-element colour edits.
- **Theme switching:** a no-flash inline script in `layouts/app.blade.php`
  sets `data-theme` on `<html>` before first paint (**defaults to dark**);
  the nav toggle persists the choice in `localStorage`. The script sets the
  attribute client-side only — the server-rendered `<html>` tag stays exactly
  `<html lang=".." dir="..">`, which `SeoTest` asserts verbatim, so never add
  theme attributes to the `<html>` tag in Blade.
- When adding a new coloured utility to a template, add its dark remap to the
  `[data-theme="dark"]` block, or it will be unreadable on the dark ground.
- The wordmark PNG is black-on-transparent; `.site-logo` is inverted to white
  in dark mode.

## Admin panel

`/admin` (gated by `AdminMiddleware` + `User.is_admin`) is the single control
surface and uses an **Apple-style Liquid Glass** design — frosted translucent
chrome over a vibrant aurora backdrop. This look is **admin-only**: it is CSS
scoped to the `.admin-shell` body class in `resources/css/app.css`, which remaps
the admin views' Tailwind gray utilities into glass (so admin view markup did
not change). The public site's dark theme is entirely separate.

Beyond the content CRUD (blog, projects, systems, clients, technologies,
contacts, quotes), the admin manages:

- **Users** — `Admin\UserController` CRUD; guards stop an admin deleting or
  demoting their own account.
- **Site settings** — the `settings` table (key/value) overlays `config('site.*')`
  in `AppServiceProvider::boot()` (contact email/phone/address + social). Existing
  `config('site.*')` calls pick up edits with no code change. `config/site.php`
  stays as the defaults. The overlay runs per request (each real request is a
  fresh boot), so it works even with `config:cache`.
- **FAQs** — the `faqs` table + `Admin\FaqController`; the contact page uses DB
  FAQs when present and **falls back to `lang/**/contact.php`** when the table is
  empty (this keeps `SeoTest`'s FAQ assertion green on the fresh test DB).
- **Page content & SEO** — `Admin\ContentController` edits any `lang/**` string
  in either language via the `translations` table, overlaid at runtime by
  `app/Translation/DatabaseTranslationLoader.php` (registered in
  `AppServiceProvider::register()` by decorating `translation.loader`). No `__()`
  call changed. The loader falls back to file values if the table is missing or a
  query fails. Clearing a field in the editor restores the file default.

**Gotchas for future work here:**
- Never name a route parameter `locale` — the global `SetLocale` middleware
  forgets it. The content routes use `{lang}` for this reason.
- Anything moved from `lang/**` or `config/site.php` into the DB must keep the
  file/config value as the fallback, or the no-seed test DB will fail.
- The `Setting`/`Translation` models cache their reads (`Cache::rememberForever`)
  and flush on save — clear those caches if you write rows directly.

## Working agreement

For any change that touches more than a couple of files or shifts
messaging/positioning, propose an approach and wait for approval before
implementing. Commit at logical checkpoints so there are rollback points.
After a content or positioning change, verify against
`tests/Feature/SeoTest.php` and spot-check the rendered `<head>` of a couple
of matching `/ar/*` and `/en/*` pages for hreflang correctness before calling
it done.
