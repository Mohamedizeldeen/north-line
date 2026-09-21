<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Collapses the paired locale='ar'/locale='en' rows in projects into one row
 * per project. See 2026_09_21_000001_merge_systems_into_bilingual_rows for
 * the rationale — same shape, applied to projects.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('title_ar')->nullable()->after('id');
            $table->string('title_en')->nullable()->after('title_ar');
            $table->string('slug_ar')->nullable()->unique()->after('title_en');
            $table->string('slug_en')->nullable()->unique()->after('slug_ar');
            $table->text('description_ar')->nullable()->after('slug_en');
            $table->text('description_en')->nullable()->after('description_ar');
            $table->longText('content_ar')->nullable()->after('description_en');
            $table->longText('content_en')->nullable()->after('content_ar');
        });

        $rows = DB::table('projects')->orderBy('id')->get();

        foreach ($rows->groupBy(fn ($r) => $r->translation_group_id ?? $r->id) as $group) {
            $ar = $group->firstWhere('locale', 'ar');
            $en = $group->firstWhere('locale', 'en');
            $primary = $ar ?? $en;

            DB::table('projects')->where('id', $primary->id)->update([
                'title_ar' => $ar->title ?? null,
                'title_en' => $en->title ?? null,
                'slug_ar' => $ar->slug ?? null,
                'slug_en' => $en->slug ?? null,
                'description_ar' => $ar->description ?? null,
                'description_en' => $en->description ?? null,
                'content_ar' => $ar->content ?? null,
                'content_en' => $en->content ?? null,
            ]);

            $extras = $group->pluck('id')->reject(fn ($id) => $id === $primary->id);

            if ($extras->isNotEmpty()) {
                DB::table('projects')->whereIn('id', $extras)->delete();
            }
        }

        Schema::table('projects', function (Blueprint $table) {
            $table->dropUnique(['locale', 'slug']);
            $table->dropIndex(['locale']);
            $table->dropIndex(['translation_group_id']);
            $table->dropColumn(['locale', 'translation_group_id', 'title', 'slug', 'description', 'content']);
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('locale', 5)->default('ar')->after('id')->index();
            $table->unsignedBigInteger('translation_group_id')->nullable()->after('locale')->index();
            $table->string('title')->nullable()->after('translation_group_id');
            $table->string('slug')->nullable()->after('title');
            $table->text('description')->nullable()->after('slug');
            $table->longText('content')->nullable()->after('description');
        });

        foreach (DB::table('projects')->get() as $row) {
            $groupId = $row->id;

            if ($row->title_ar) {
                DB::table('projects')->where('id', $row->id)->update([
                    'locale' => 'ar',
                    'translation_group_id' => $groupId,
                    'title' => $row->title_ar,
                    'slug' => $row->slug_ar,
                    'description' => $row->description_ar,
                    'content' => $row->content_ar,
                ]);

                if ($row->title_en) {
                    $enAttrs = (array) $row;
                    unset($enAttrs['id']);
                    $enAttrs = array_merge($enAttrs, [
                        'locale' => 'en',
                        'translation_group_id' => $groupId,
                        'title' => $row->title_en,
                        'slug' => $row->slug_en,
                        'description' => $row->description_en,
                        'content' => $row->content_en,
                    ]);
                    DB::table('projects')->insert($enAttrs);
                }
            } elseif ($row->title_en) {
                DB::table('projects')->where('id', $row->id)->update([
                    'locale' => 'en',
                    'translation_group_id' => $groupId,
                    'title' => $row->title_en,
                    'slug' => $row->slug_en,
                    'description' => $row->description_en,
                    'content' => $row->content_en,
                ]);
            }
        }

        Schema::table('projects', function (Blueprint $table) {
            $table->dropUnique(['slug_ar']);
            $table->dropUnique(['slug_en']);
            $table->dropColumn(['title_ar', 'title_en', 'slug_ar', 'slug_en', 'description_ar', 'description_en', 'content_ar', 'content_en']);
            $table->unique(['locale', 'slug']);
        });
    }
};
