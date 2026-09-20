<?php

namespace Database\Seeders;

use App\Models\System;
use Illuminate\Database\Seeder;

/**
 * The eleven service areas North Line actually sells, in Arabic and English.
 *
 * Replaces the fashion-vertical product catalog from ProductSeeder. Arabic
 * and English rows are paired through translation_group_id so the language
 * switcher and hreflang can find each other. Idempotent — safe to re-run.
 */
class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->services() as $order => $service) {
            $ar = System::updateOrCreate(
                ['locale' => 'ar', 'slug' => $service['ar']['slug']],
                [
                    'title' => $service['ar']['title'],
                    'description' => $service['ar']['description'],
                    'content' => $service['ar']['content'],
                    'is_published' => true,
                    'sort_order' => $order,
                ]
            );

            // The Arabic row anchors the group: Arabic is the primary language.
            $ar->forceFill(['translation_group_id' => $ar->translation_group_id ?? $ar->id])->save();

            System::updateOrCreate(
                ['locale' => 'en', 'slug' => $service['en']['slug']],
                [
                    'title' => $service['en']['title'],
                    'description' => $service['en']['description'],
                    'content' => $service['en']['content'],
                    'is_published' => true,
                    'sort_order' => $order,
                    'translation_group_id' => $ar->translation_group_id,
                ]
            );
        }

        // The old catalog (fashion products, and the legacy Northxxx rows
        // before them) is not what we sell any more.
        System::whereNotIn('slug', collect($this->services())
            ->flatMap(fn ($s) => [$s['ar']['slug'], $s['en']['slug']])->all())
            ->update(['is_published' => false]);
    }

    private function services(): array
    {
        return [
            [
                'ar' => [
                    'slug' => 'التقييم-الرقمي',
                    'title' => 'التقييم الرقمي',
                    'description' => 'نراجع أنظمتك وعملياتك الحالية، ونحدد بالضبط وين الفجوات ووش يستحق تحويله رقمياً أول.',
                    'content' => <<<'MD'
                        نبدأ كل مشروع بفهم وضعك الفعلي، مو بافتراضات جاهزة.

                        ## وش نراجعه
                        الأنظمة اللي تستخدمها الآن، العمليات اليدوية، ونقاط الضعف اللي تكلّفك وقتاً أو فلوساً.

                        ## المخرج
                        تقرير واضح يبيّن الفجوات، ويرتّب الأولويات حسب الأثر والتكلفة — أساس تُبنى عليه أي خطوة بعده.
                        MD,
                ],
                'en' => [
                    'slug' => 'digital-assessment',
                    'title' => 'Digital Assessment',
                    'description' => 'We review your current systems and processes, and pinpoint exactly where the gaps are and what is worth digitizing first.',
                    'content' => <<<'MD'
                        Every project starts with understanding where you actually stand, not assumptions.

                        ## What we review
                        The systems you use today, the manual processes around them, and the weak points costing you time or money.

                        ## What you get
                        A clear report that maps the gaps and ranks them by impact and cost — the foundation every next step is built on.
                        MD,
                ],
            ],
            [
                'ar' => [
                    'slug' => 'الاستراتيجية-وخارطة-الطريق',
                    'title' => 'الاستراتيجية وخارطة الطريق',
                    'description' => 'نحدد وش يُرقمن أول ووش ينتظر، بخطة واضحة بمراحل وميزانية تقديرية لكل مرحلة.',
                    'content' => <<<'MD'
                        التقييم يقول لك وين الفجوات. الاستراتيجية تقول لك بأي ترتيب تسدّها.

                        ## ترتيب حسب الأثر
                        نرتّب المبادرات حسب العائد المتوقع والجهد المطلوب، فتبدأ بأكثر شي يفرق في عملك.

                        ## خطة قابلة للتنفيذ
                        مراحل زمنية واضحة، وميزانية تقديرية لكل مرحلة، بدون التزام بكل المشروع دفعة وحدة.
                        MD,
                ],
                'en' => [
                    'slug' => 'strategy-roadmap',
                    'title' => 'Strategy & Roadmap',
                    'description' => 'We decide what gets digitized first and what can wait, with a clear phased plan and an estimated budget per phase.',
                    'content' => <<<'MD'
                        The assessment tells you where the gaps are. The strategy tells you in what order to close them.

                        ## Ranked by impact
                        We order initiatives by expected return and required effort, so you start with what actually moves your business.

                        ## A plan you can execute
                        Clear phases with an estimated budget for each one — no commitment to the whole project at once.
                        MD,
                ],
            ],
            [
                'ar' => [
                    'slug' => 'البرمجيات-المخصصة',
                    'title' => 'البرمجيات المخصصة',
                    'description' => 'أنظمة ERP وCRM وبوابات وتطبيقات جوال مبنية على طريقة شغل شركتك بالضبط، مو قالب جاهز.',
                    'content' => <<<'MD'
                        البرنامج الجاهز يفرض عليك طريقة شغل. نبني برنامجك حول طريقة شغلك أنت.

                        ## أنواع الأنظمة
                        أنظمة ERP وCRM، بوابات للعملاء أو الموظفين، تطبيقات جوال، وأنظمة داخلية مخصصة لأي قسم.

                        ## يكبر مع شركتك
                        نبني بطريقة تسمح بالإضافة لاحقاً — قسم جديد أو فرع جديد ما يعني إعادة بناء من الصفر.
                        MD,
                ],
                'en' => [
                    'slug' => 'custom-software',
                    'title' => 'Custom Software',
                    'description' => 'ERP, CRM, portals, and mobile apps built around exactly how your company works, not a ready-made template.',
                    'content' => <<<'MD'
                        Off-the-shelf software forces a way of working on you. We build software around how you actually work.

                        ## What we build
                        ERP and CRM systems, customer or employee portals, mobile apps, and internal systems for any department.

                        ## Grows with you
                        Built so a new department or a new branch means an addition, not a rebuild from zero.
                        MD,
                ],
            ],
            [
                'ar' => [
                    'slug' => 'أتمتة-العمليات',
                    'title' => 'أتمتة العمليات',
                    'description' => 'نستبدل الإكسل والورق ورسائل الواتساب بعمليات آلية تشتغل بدون تدخل يدوي متكرر.',
                    'content' => <<<'MD'
                        كل خطوة تتكرر يدوياً كل يوم هي وقت وفرصة خطأ.

                        ## وش نؤتمت
                        الموافقات، إدخال البيانات المتكرر، التقارير الدورية، والتنسيق بين الأقسام.

                        ## النتيجة
                        موظفوك يركزون على شغل يحتاج تفكير، مو نسخ ولصق.
                        MD,
                ],
                'en' => [
                    'slug' => 'process-automation',
                    'title' => 'Process Automation',
                    'description' => 'We replace spreadsheets, paper, and WhatsApp workflows with automated processes that run without repeated manual work.',
                    'content' => <<<'MD'
                        Every step that repeats manually every day is lost time and a chance for error.

                        ## What we automate
                        Approvals, repetitive data entry, recurring reports, and handoffs between departments.

                        ## The result
                        Your team spends time on work that needs judgment, not copy-paste.
                        MD,
                ],
            ],
            [
                'ar' => [
                    'slug' => 'تكامل-الأنظمة',
                    'title' => 'تكامل الأنظمة',
                    'description' => 'نربط ERP وCRM وبوابات الدفع وموقعك وكل أنظمتك ببعض، فتشتغل كوحدة واحدة بدل أنظمة منفصلة.',
                    'content' => <<<'MD'
                        أغلب الشركات ما تحتاج نظاماً جديداً — تحتاج أنظمتها الحالية تتكلم مع بعض.

                        ## أنظمة نربطها
                        ERP، CRM، بوابات الدفع، المواقع الإلكترونية، وأي نظام عنده API أو قاعدة بيانات.

                        ## بيانات موحّدة
                        تدخل الرقم مرة وحدة، ويتحدث في كل الأنظمة تلقائياً — بدون نسخ يدوي بين برنامج وبرنامج.
                        MD,
                ],
                'en' => [
                    'slug' => 'system-integration',
                    'title' => 'System Integration',
                    'description' => "We connect your ERP, CRM, payment gateways, website, and every other system together so they work as one, not in isolation.",
                    'content' => <<<'MD'
                        Most companies don't need a new system — they need their existing ones to talk to each other.

                        ## Systems we connect
                        ERP, CRM, payment gateways, websites, and anything with an API or a database.

                        ## One source of truth
                        Enter a number once and it updates everywhere automatically — no manual copying between systems.
                        MD,
                ],
            ],
            [
                'ar' => [
                    'slug' => 'التحول-السحابي',
                    'title' => 'التحول السحابي',
                    'description' => 'ننقل أنظمتك وبنيتك التحتية للسحابة، ونحدّث البنية التقنية لتكون أسرع وأكثر أماناً وأقل تكلفة.',
                    'content' => <<<'MD'
                        البنية التحتية القديمة تكلّف صيانة وأجهزة وتحد من قدرتك على التوسع.

                        ## الانتقال بدون توقف
                        ننقل أنظمتك للسحابة بخطة مرحلية تحافظ على استمرار العمل أثناء الانتقال.

                        ## بعد الانتقال
                        أداء أسرع، نسخ احتياطي تلقائي، وقدرة على التوسع بدون شراء أجهزة جديدة.
                        MD,
                ],
                'en' => [
                    'slug' => 'cloud-transformation',
                    'title' => 'Cloud Transformation',
                    'description' => 'We move your systems and infrastructure to the cloud and modernize the architecture to be faster, more secure, and lower cost.',
                    'content' => <<<'MD'
                        Old infrastructure costs you maintenance, hardware, and the ability to scale.

                        ## Moving without downtime
                        We migrate to the cloud in phases that keep the business running throughout.

                        ## After the move
                        Faster performance, automatic backups, and the ability to scale without buying new hardware.
                        MD,
                ],
            ],
            [
                'ar' => [
                    'slug' => 'البيانات-وذكاء-الأعمال',
                    'title' => 'البيانات وذكاء الأعمال',
                    'description' => 'لوحات ومؤشرات وتقارير مركزية تعطيك صورة دقيقة عن شركتك في أي لحظة، بدل انتظار نهاية الشهر.',
                    'content' => <<<'MD'
                        البيانات موجودة عندك أصلاً — المشكلة إنها متفرقة وما أحد يقرأها.

                        ## لوحات تفاعلية
                        مؤشرات أداء ولوحات مرئية تجمع بيانات كل أقسامك في مكان واحد.

                        ## قرارات مبنية على أرقام
                        تعرف وش يبيع، وش يتأخر، ووين الفرصة — لحظياً، مو في تقرير شهري متأخر.
                        MD,
                ],
                'en' => [
                    'slug' => 'data-bi',
                    'title' => 'Data & BI',
                    'description' => 'Centralized dashboards, metrics, and reports that give you an accurate picture of your business at any moment, not at month end.',
                    'content' => <<<'MD'
                        The data already exists in your business — the problem is it's scattered and nobody reads it.

                        ## Interactive dashboards
                        KPIs and visual dashboards that bring every department's data into one place.

                        ## Decisions built on numbers
                        See what's selling, what's lagging, and where the opportunity is — in real time, not in a report that's a month late.
                        MD,
                ],
            ],
            [
                'ar' => [
                    'slug' => 'الذكاء-الاصطناعي-والأتمتة',
                    'title' => 'الذكاء الاصطناعي والأتمتة',
                    'description' => 'مساعدات ذكاء اصطناعي، معالجة مستندات آلية، وتوقعات مبنية على بياناتك الفعلية.',
                    'content' => <<<'MD'
                        الذكاء الاصطناعي مفيد لما يُبنى على مشكلة حقيقية، مو مجرد إضافة تقنية.

                        ## أمثلة على وش نبنيه
                        مساعدات تجيب على استفسارات العملاء، أنظمة تقرأ المستندات وتستخرج البيانات منها تلقائياً، ونماذج تتوقع الطلب أو المخزون.

                        ## مبني على بياناتك
                        النماذج تتدرب على بيانات شركتك الفعلية، فالنتائج تخدم وضعك أنت، مو حالة عامة.
                        MD,
                ],
                'en' => [
                    'slug' => 'ai-automation',
                    'title' => 'AI & Automation',
                    'description' => 'AI assistants, automated document processing, and forecasting models built on your actual business data.',
                    'content' => <<<'MD'
                        AI is useful when it's built around a real problem, not added as a feature for its own sake.

                        ## What we build
                        Assistants that answer customer questions, systems that read documents and extract data automatically, and models that forecast demand or stock.

                        ## Built on your data
                        Models are trained on your company's actual data, so results fit your situation, not a generic case.
                        MD,
                ],
            ],
            [
                'ar' => [
                    'slug' => 'الأمن-السيبراني-والحوكمة',
                    'title' => 'الأمن السيبراني والحوكمة',
                    'description' => 'تقييم أمني، صلاحيات وصول واضحة، وسياسات حوكمة تحمي بيانات شركتك وعملائك.',
                    'content' => <<<'MD'
                        الأمن جزء من كل مشروع نبنيه، مو خطوة تُضاف في الآخر.

                        ## وش نغطيه
                        تقييم الثغرات، صلاحيات وصول محددة لكل موظف، تشفير البيانات الحساسة، وسياسات واضحة للتعامل معها.

                        ## الالتزام والحوكمة
                        نساعدك توثّق سياساتك الأمنية بطريقة تلبي متطلبات الجهات الرقابية في عُمان.
                        MD,
                ],
                'en' => [
                    'slug' => 'cybersecurity-governance',
                    'title' => 'Cybersecurity & Governance',
                    'description' => "Security assessments, clear access controls, and governance policies that protect your company's and customers' data.",
                    'content' => <<<'MD'
                        Security is part of every project we build, not a step added at the end.

                        ## What we cover
                        Vulnerability assessment, defined access levels per employee, encryption of sensitive data, and clear policies for handling it.

                        ## Compliance and governance
                        We help you document your security policies in a way that meets Omani regulatory requirements.
                        MD,
                ],
            ],
            [
                'ar' => [
                    'slug' => 'التدريب-وإدارة-التغيير',
                    'title' => 'التدريب وإدارة التغيير',
                    'description' => 'ندرّب فريقك على النظام الجديد، ونساعدهم يتبنّونه فعلياً بدل ما يرجعون للطريقة القديمة.',
                    'content' => <<<'MD'
                        أفضل نظام ما يفيد إذا فريقك ما يستخدمه.

                        ## تدريب عملي
                        جلسات تدريب على النظام الفعلي، بأمثلة من شغل فريقك اليومي، مو عرض تقديمي عام.

                        ## تبنٍّ حقيقي
                        نتابع بعد الإطلاق، ونحل أي مقاومة أو التباس قبل ما يرجع الفريق للطريقة القديمة.
                        MD,
                ],
                'en' => [
                    'slug' => 'training-change-management',
                    'title' => 'Training & Change Management',
                    'description' => "We train your team on the new system and help them actually adopt it, instead of drifting back to the old way.",
                    'content' => <<<'MD'
                        The best system is worthless if your team doesn't use it.

                        ## Hands-on training
                        Training sessions on the real system, using examples from your team's daily work, not a generic slideshow.

                        ## Real adoption
                        We follow up after launch and resolve resistance or confusion before the team drifts back to the old way.
                        MD,
                ],
            ],
            [
                'ar' => [
                    'slug' => 'الدعم-المستمر',
                    'title' => 'الدعم المستمر',
                    'description' => 'مراقبة وتحسين وصيانة بعد الإطلاق، وفريق يعرف نظامك يكبر معه أولاً بأول.',
                    'content' => <<<'MD'
                        المشروع ما ينتهي عند الإطلاق — يبدأ منه.

                        ## وش نقدمه
                        مراقبة مستمرة للأداء، إصلاح سريع لأي مشكلة، وتحديثات دورية مع تغيّر احتياجك.

                        ## فريق ثابت
                        نفس الفريق اللي بنى النظام يتابعه بعد الإطلاق — ما تعيد شرح مشروعك لفريق جديد كل مرة.
                        MD,
                ],
                'en' => [
                    'slug' => 'ongoing-support',
                    'title' => 'Ongoing Support',
                    'description' => 'Monitoring, optimization, and maintenance after launch, with a team that already knows your system as it grows.',
                    'content' => <<<'MD'
                        A project doesn't end at launch — that's where it starts.

                        ## What we provide
                        Continuous performance monitoring, fast fixes when something breaks, and regular updates as your needs change.

                        ## The same team
                        The team that built your system stays with it after launch — you never re-explain your project to someone new.
                        MD,
                ],
            ],
        ];
    }
}
