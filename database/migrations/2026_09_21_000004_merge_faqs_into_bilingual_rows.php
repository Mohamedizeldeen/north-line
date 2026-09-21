<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Collapses the paired locale='ar'/locale='en' rows in faqs into one row per
 * FAQ. See 2026_09_21_000001_merge_systems_into_bilingual_rows for the
 * rationale. FAQs have no slug/route, so this is the simplest of the four.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->string('question_ar')->nullable()->after('id');
            $table->string('question_en')->nullable()->after('question_ar');
            $table->text('answer_ar')->nullable()->after('question_en');
            $table->text('answer_en')->nullable()->after('answer_ar');
        });

        $rows = DB::table('faqs')->orderBy('id')->get();

        foreach ($rows->groupBy(fn ($r) => $r->translation_group_id ?? $r->id) as $group) {
            $ar = $group->firstWhere('locale', 'ar');
            $en = $group->firstWhere('locale', 'en');
            $primary = $ar ?? $en;

            DB::table('faqs')->where('id', $primary->id)->update([
                'question_ar' => $ar->question ?? null,
                'question_en' => $en->question ?? null,
                'answer_ar' => $ar->answer ?? null,
                'answer_en' => $en->answer ?? null,
            ]);

            $extras = $group->pluck('id')->reject(fn ($id) => $id === $primary->id);

            if ($extras->isNotEmpty()) {
                DB::table('faqs')->whereIn('id', $extras)->delete();
            }
        }

        Schema::table('faqs', function (Blueprint $table) {
            $table->dropIndex(['locale']);
            $table->dropIndex(['translation_group_id']);
            $table->dropColumn(['locale', 'translation_group_id', 'question', 'answer']);
        });
    }

    public function down(): void
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->string('locale', 5)->default('ar')->after('id')->index();
            $table->unsignedBigInteger('translation_group_id')->nullable()->after('locale')->index();
            $table->string('question')->nullable()->after('translation_group_id');
            $table->text('answer')->nullable()->after('question');
        });

        foreach (DB::table('faqs')->get() as $row) {
            $groupId = $row->id;

            if ($row->question_ar) {
                DB::table('faqs')->where('id', $row->id)->update([
                    'locale' => 'ar',
                    'translation_group_id' => $groupId,
                    'question' => $row->question_ar,
                    'answer' => $row->answer_ar,
                ]);

                if ($row->question_en) {
                    $enAttrs = (array) $row;
                    unset($enAttrs['id']);
                    $enAttrs = array_merge($enAttrs, [
                        'locale' => 'en',
                        'translation_group_id' => $groupId,
                        'question' => $row->question_en,
                        'answer' => $row->answer_en,
                    ]);
                    DB::table('faqs')->insert($enAttrs);
                }
            } elseif ($row->question_en) {
                DB::table('faqs')->where('id', $row->id)->update([
                    'locale' => 'en',
                    'translation_group_id' => $groupId,
                    'question' => $row->question_en,
                    'answer' => $row->answer_en,
                ]);
            }
        }

        Schema::table('faqs', function (Blueprint $table) {
            $table->dropColumn(['question_ar', 'question_en', 'answer_ar', 'answer_en']);
        });
    }
};
