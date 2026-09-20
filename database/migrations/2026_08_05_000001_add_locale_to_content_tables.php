<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Gives content a language.
 *
 * Each row is one language of one piece of content. Rows that are translations
 * of each other share a translation_group_id, which is what the hreflang pair
 * and the language switcher read.
 *
 * A per-locale row rather than title_ar/title_en columns, because the two
 * languages are NOT always translations: the Arabic commercial articles have no
 * English twin, and the legacy English developer posts have no Arabic one.
 * Paired columns would force empty pages into existence for the missing side.
 */
return new class extends Migration
{
    private const TABLES = ['blog_posts', 'projects', 'systems'];

    public function up(): void
    {
        foreach (self::TABLES as $table) {
            Schema::table($table, function (Blueprint $t) use ($table) {
                $t->string('locale', 5)->default('ar')->after('id')->index();
                $t->unsignedBigInteger('translation_group_id')->nullable()->after('locale')->index();

                if ($table === 'blog_posts') {
                    // Legacy developer-facing posts stay published but leave the
                    // main feed; they are not what the audience buys on.
                    $t->boolean('is_technical')->default(false)->after('is_published')->index();
                }
            });

            // Everything that exists today was written in English.
            DB::table($table)->update(['locale' => 'en']);

            // A slug is only unique within a language — /ar/blog/x and
            // /en/blog/x are different documents.
            Schema::table($table, function (Blueprint $t) {
                $t->dropUnique($t->getTable().'_slug_unique');
                $t->unique(['locale', 'slug']);
            });
        }

        // Each existing row is its own translation group until a sibling is added.
        foreach (self::TABLES as $table) {
            DB::table($table)->update(['translation_group_id' => DB::raw('id')]);
        }

        DB::table('blog_posts')->update(['is_technical' => true]);
    }

    public function down(): void
    {
        foreach (self::TABLES as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->dropUnique(['locale', 'slug']);
            });

            Schema::table($table, function (Blueprint $t) use ($table) {
                $t->dropIndex([$table.'_locale_index']);
                $t->dropIndex([$table.'_translation_group_id_index']);
                $t->dropColumn(['locale', 'translation_group_id']);

                if ($table === 'blog_posts') {
                    $t->dropIndex('blog_posts_is_technical_index');
                    $t->dropColumn('is_technical');
                }
            });

            Schema::table($table, function (Blueprint $t) {
                $t->unique('slug');
            });
        }
    }
};
