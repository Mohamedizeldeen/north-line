<?php

namespace Database\Seeders;

use App\Models\System;
use Illuminate\Database\Seeder;

/**
 * The five products North Line actually sells, in Arabic and English.
 *
 * Replaces the generic "Systems & SaaS" entries. Arabic and English rows are
 * paired through translation_group_id so the language switcher and hreflang
 * can find each other. Idempotent — safe to re-run.
 */
class ProductSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->products() as $order => $product) {
            System::updateOrCreate(
                ['slug_ar' => $product['ar']['slug']],
                [
                    'title_ar' => $product['ar']['title'],
                    'description_ar' => $product['ar']['description'],
                    'content_ar' => $product['ar']['content'],
                    'slug_en' => $product['en']['slug'],
                    'title_en' => $product['en']['title'],
                    'description_en' => $product['en']['description'],
                    'content_en' => $product['en']['content'],
                    'is_published' => true,
                    'sort_order' => $order,
                ]
            );
        }

        // The old generic entries are not what we sell any more.
        System::whereNotIn('slug_ar', collect($this->products())->pluck('ar.slug')->all())
            ->update(['is_published' => false]);
    }

    private function products(): array
    {
        return [
            [
                'ar' => [
                    'slug' => 'متجر-إلكتروني',
                    'title' => 'متجر إلكتروني',
                    'description' => 'متجر عربي يشتغل من الجوال، مربوط بأموال باي، تطلب منه العميلة وتدفع بنفسها بدون ما ترسل لك رسالة واحدة.',
                    'content' => <<<'MD'
                        متجر بالعربي مصمّم للجوال أولاً، لأن أغلب عميلاتك يدخلن من الإنستقرام.

                        ## العميلة تطلب وتدفع بنفسها
                        تختار المقاس واللون، تدفع ببطاقتها، ويوصلها تأكيد الطلب — بدون تبادل رسائل ولا تحويل بنكي يدوي.

                        ## الدفع عبر أموال باي
                        بوابة دفع عُمانية مرخّصة من البنك المركزي العماني. الفلوس توصل حسابك مباشرة.

                        ## المخزون مربوط بالمحل
                        كل قطعة تنباع من المتجر تنقص من نفس المخزون اللي يبيع منه الكاشير في المحل.
                        MD,
                ],
                'en' => [
                    'slug' => 'online-store',
                    'title' => 'Online store',
                    'description' => 'An Arabic, mobile-first store connected to Amwal Pay, where customers order and pay themselves without sending you a single message.',
                    'content' => <<<'MD'
                        An Arabic store designed for phones first, because most of your customers arrive from Instagram.

                        ## She orders and pays herself
                        She picks the size and colour, pays by card, and gets an order confirmation — no message thread, no manual bank transfer.

                        ## Payment through Amwal Pay
                        An Omani payment gateway licensed by the Central Bank of Oman. Money reaches your account directly.

                        ## Stock tied to the shop
                        Every piece sold online comes off the same stock the till in your shop sells from.
                        MD,
                ],
            ],
            [
                'ar' => [
                    'slug' => 'تجربة-قياس-افتراضية',
                    'title' => 'تجربة قياس افتراضية',
                    'description' => 'العميلة تشوف القطعة عليها قبل ما تطلب. يقلّل التردد قبل الشراء ويقلّل الإرجاع بعده.',
                    'content' => <<<'MD'
                        العميلة ترفع صورتها وتشوف القطعة عليها قبل ما تطلبها.

                        ## ليش يفرق
                        أكبر سبب للتردد في شراء الأزياء أونلاين هو "ما أدري كيف بتطلع عليّ". لما تشوفها، تقل الأسئلة في الرسائل ويقل الإرجاع.

                        ## خصوصية العميلة
                        الصورة تُحذف مباشرة بعد التجربة. لا تُخزَّن، ولا تُستخدم لأي غرض آخر.
                        MD,
                ],
                'en' => [
                    'slug' => 'virtual-try-on',
                    'title' => 'Virtual try-on',
                    'description' => 'She sees the piece on herself before ordering. Less hesitation before the sale, and fewer returns after it.',
                    'content' => <<<'MD'
                        A customer uploads her photo and sees the piece on herself before she orders it.

                        ## Why it matters
                        The biggest reason people hesitate to buy fashion online is not knowing how it will look on them. Seeing it cuts the back-and-forth questions and cuts returns.

                        ## Her privacy
                        The photo is deleted immediately after the try-on. It is never stored and never used for anything else.
                        MD,
                ],
            ],
            [
                'ar' => [
                    'slug' => 'نقطة-بيع',
                    'title' => 'نقطة بيع (كاشير)',
                    'description' => 'كاشير سريع للمحل يشتغل باللمس، يطبع الفاتورة، ويخصم القطعة من المخزون في نفس اللحظة.',
                    'content' => <<<'MD'
                        كاشير مصمّم لمحل أزياء، مو لمطعم ولا بقالة.

                        ## المقاسات والألوان
                        كل قطعة لها مقاسات وألوان، وكلٍ منها له رصيد مستقل. تعرفين بالضبط وش باقي من كل مقاس.

                        ## الإرجاع والاستبدال
                        عمليات الإرجاع والاستبدال ترجع القطعة للمخزون تلقائياً.

                        ## يشتغل مع الفروع
                        كل فرع له رصيده، وكلها تحت مخزون واحد تشوفينه من مكان واحد.
                        MD,
                ],
                'en' => [
                    'slug' => 'point-of-sale',
                    'title' => 'Point of sale',
                    'description' => 'A fast touch-screen till for the shop that prints the receipt and takes the piece out of stock in the same moment.',
                    'content' => <<<'MD'
                        A till built for a fashion shop, not a restaurant or a grocery.

                        ## Sizes and colours
                        Every piece has sizes and colours, each with its own stock count. You know exactly what is left in every size.

                        ## Returns and exchanges
                        Returns and exchanges put the piece back into stock automatically.

                        ## Works across branches
                        Each branch has its own count, all under one inventory you can see from one place.
                        MD,
                ],
            ],
            [
                'ar' => [
                    'slug' => 'مخزون-موحد',
                    'title' => 'مخزون موحّد',
                    'description' => 'مخزون واحد لكل الفروع والمتجر الإلكتروني. تبيعين قطعة في الخوض فتنقص من المتجر فوراً — ما فيه بيع مزدوج.',
                    'content' => <<<'MD'
                        هذا هو الفرق الأساسي بيننا وبين أي حل يبيع أونلاين فقط.

                        ## قطعة واحدة، رصيد واحد
                        القطعة اللي تنباع في المحل تختفي من المتجر الإلكتروني في نفس اللحظة، والعكس. ما تبيعين نفس العباية مرتين.

                        ## تقارير تعرفين منها وش يبيع
                        وش يتحرك ووش راكد، وأي فرع يبيع أكثر، وأي مقاس ينفد أول. الطلبية الجاية تنشرى بمعلومة مو بحدس.
                        MD,
                ],
                'en' => [
                    'slug' => 'unified-inventory',
                    'title' => 'Unified inventory',
                    'description' => 'One stock across every branch and the online store. Sell a piece in Al Khoud and it disappears from the store instantly — no double sale.',
                    'content' => <<<'MD'
                        This is the core difference between us and anything that only sells online.

                        ## One piece, one count
                        A piece sold in the shop disappears from the online store in the same moment, and the other way round. You never sell the same abaya twice.

                        ## Reports that tell you what sells
                        What moves and what sits, which branch sells most, which size runs out first. The next order gets placed on information, not instinct.
                        MD,
                ],
            ],
            [
                'ar' => [
                    'slug' => 'نظام-محاسبي',
                    'title' => 'نظام محاسبي',
                    'description' => 'مبيعاتك ومصاريفك وأرباحك في مكان واحد، جاهزة لإقرار ضريبة القيمة المضافة بدون ملفات إكسل.',
                    'content' => <<<'MD'
                        محاسبة مربوطة بالمبيعات مباشرة، فما تحتاجين تدخلين الأرقام مرتين.

                        ## جاهز لإقرار الضريبة
                        ضريبة القيمة المضافة محسوبة من الفواتير نفسها، وتطلعين التقرير جاهز وقت الإقرار.

                        ## ربح كل قطعة
                        تعرفين ربحك على مستوى القطعة، مو بس إجمالي المبيعات في آخر الشهر.
                        MD,
                ],
                'en' => [
                    'slug' => 'accounting',
                    'title' => 'Accounting',
                    'description' => 'Sales, expenses and profit in one place, ready for your VAT return without a single spreadsheet.',
                    'content' => <<<'MD'
                        Accounting wired straight into sales, so you never enter a number twice.

                        ## Ready for the VAT return
                        VAT is calculated from the invoices themselves, and the report comes out ready when the return is due.

                        ## Profit per piece
                        You see profit at the level of a single piece, not just total sales at the end of the month.
                        MD,
                ],
            ],
        ];
    }
}
