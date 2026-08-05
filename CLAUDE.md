# North Line Development — Website Overhaul

## About this project

North Line Development is an Omani software company based in Al Khoud, Muscat.
5+ years in business, 50+ projects, 30+ clients. Portfolio includes the
Muscat Fashion Week website.

We are repositioning from a generalist dev shop to a **vertical specialist**:
integrated systems for fashion retail in Oman.

### Positioning

- **AR:** النظام الكامل لمحل الأزياء في عُمان — متجر إلكتروني، نقطة بيع، ومخزون واحد
- **EN:** The complete system for Omani fashion stores — online store, POS, and one unified inventory.

### Product stack (all already built)

- E-commerce store with AI virtual try-on
- POS with unified inventory across store and online
- Amwal Pay integration (Omani gateway, licensed by the Central Bank of Oman)
- Email marketing integration
- Accounting system

### Target customer

Fashion and abaya boutiques in Muscat, 1–3 branches, who also sell through
Instagram DMs. The decision maker is the owner. She is non-technical and buys
in **Arabic**.

### Core pain we solve

Double inventory (the same item sold in-store *and* online), orders lost in
Instagram DMs, no reporting.

## Hard constraints

- **Arabic is the PRIMARY language**, English is secondary.
- Proper **RTL** support throughout.
- Copy targets **shop owners, NOT developers** — zero technical jargon.
  Never say Laravel, API, framework, or stack in customer-facing copy.
- **Mobile-first**: most traffic arrives from Instagram.

## Arabic SEO targets

- نظام إدارة محل ملابس
- برنامج كاشير للأزياء عمان
- متجر إلكتروني للعبايات
- تجربة قياس افتراضية
- كم تكلفة متجر إلكتروني في عمان
- برنامج محاسبي عماني

## Working agreement

Work the phases **in order**. After each phase: stop, summarize what changed,
and wait for approval before continuing. Commit after each approved phase so
there are rollback points.

## Phases

### PHASE 1 — Audit (change nothing)

Report on:

1. Framework, version, how routes/pages are defined
2. How page metadata (title, meta description, OG tags) is currently set
3. Whether any i18n library is installed
4. Whether robots.txt and sitemap.xml exist, and how the sitemap is generated
5. Any existing JSON-LD / structured data
6. CSS approach and whether it has any RTL support
7. Where blog posts live and how they render

Then recommend an approach for adding Arabic as the primary language.
Modify nothing in this phase.

### PHASE 2 — SEO foundation

1. The homepage title is currently "Home - North Line Development" — this
   wastes the most valuable SEO field on the site. Rewrite every page title to
   be descriptive and keyword-targeted, including "عُمان"/"Oman" where natural.
   Max 60 characters.
2. Unique meta description per page, 150–160 chars, with a value proposition
   and location signal.
3. Exactly one H1 per page, containing the target keyword.
4. Add JSON-LD: Organization sitewide, LocalBusiness on homepage and contact
   (Al Khoud, Muscat, Oman), FAQPage wherever FAQs exist, BreadcrumbList on
   inner pages.
5. Verify robots.txt does **not** block GPTBot, ClaudeBot, PerplexityBot, or
   Google-Extended — we want AI assistants to be able to cite us.
6. Ensure sitemap.xml covers every indexable page and is referenced in
   robots.txt.

### PHASE 3 — Arabic version (highest impact — be careful here)

- URLs: `/ar/` and `/en/`. Root redirects by Accept-Language, defaulting to Arabic.
- Full RTL: `dir="rtl"`, mirrored spacing, flipped directional icons and arrows,
  correct text alignment.
- Arabic webfont with good performance (IBM Plex Sans Arabic, Tajawal, or
  Noto Sans Arabic).

**hreflang — the easiest thing to get wrong, so verify it:**

- Self-referencing hreflang on every page
- Reciprocal: ar → en **and** en → ar (if not reciprocal, Google ignores both)
- Include `x-default`
- Each page's canonical points to **itself**, never cross-language. Never make
  the Arabic page canonical to the English one — that de-indexes Arabic entirely.

Translate **all** content, not just navigation. UI-only translation with English
body text produces duplicate pages that rank for nothing.

Add a language switcher that preserves the current path.

After this phase, show the rendered `<head>` of two matching pages for manual
hreflang verification.

### PHASE 4 — Fashion landing page at `/ar/fashion` and `/en/fashion`

1. **Hero** — outcome headline, not product name. Lead with the unified
   inventory promise. Primary CTA "شاهد الديمو" to the live demo.
2. **Problem section** in the customer's own words:
   "بعنا نفس العباية مرتين" · "الطلبات تضيع بين رسائل الإنستقرام" ·
   "ما أعرف كم قطعة باقية"
3. **Four solution blocks**: متجر إلكتروني / تجربة قياس افتراضية / نقطة بيع /
   مخزون موحّد
4. **Comparison table** vs Salla, Zid, and a standalone cashier system — show
   what only we do (POS + online + unified inventory + try-on)
5. **Trust signals**: 5 years, 50+ projects, Muscat Fashion Week, Amwal Pay
   licensed by the Central Bank of Oman
6. **FAQ block**, answers 40–60 words each, phrased as direct answers so AI
   assistants can quote them. Must include:
   - "ليش ما أستخدم سلّة؟"
   - "هل تُخزَّن صور العميلات؟" → deleted immediately, never stored, never used
     for training
   - "كم يستغرق التجهيز؟"
7. **Final CTA**: WhatsApp link, not a contact form.

Add an "آخر تحديث" date — AI search engines weight freshness heavily.

### PHASE 5 — Pricing page at `/ar/pricing` and `/en/pricing`

Real numbers as plain crawlable text. Not images, not "contact us."

Three tiers, middle one marked recommended:

| Tier | Setup | Monthly |
| --- | --- | --- |
| أونلاين | 800 OMR | 45 OMR |
| متكامل (recommended) | 1800 OMR | 90 OMR |
| متعدد الفروع | 3000 OMR | 150 OMR |

Include a what's-included vs what-costs-extra table, and a note that payment
gateway approval requires a CR and VAT certificate and takes 3–10 business days.
Add FAQPage JSON-LD.

Plain text matters because AI agents recommending vendors cannot read "contact
us for pricing" — with no number, they recommend the competitor who published one.

### PHASE 6 — Blog realignment

Existing posts are developer-facing (e.g. "why we use Laravel"). Developers
don't buy from us. Restructure the blog for Arabic commercial-intent content and
create stubs with proper metadata and internal links for:

- كم تكلفة متجر إلكتروني في عُمان؟
- أفضل نظام كاشير لمحلات الأزياء في عُمان
- متجر إلكتروني مقابل سلّة: أيهما يناسب محلك؟
- كيف تربط أموال باي بمتجرك الإلكتروني
- متى تحتاج محلك نظاماً محاسبياً بدل Excel؟

Keep existing posts but move them to a technical section, out of the main blog feed.
