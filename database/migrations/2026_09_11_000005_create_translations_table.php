<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale', 5);
            $table->string('group');            // e.g. home, seo, nav
            $table->string('item');             // dotted key within the group, e.g. hero.title
            $table->text('value')->nullable();
            $table->timestamps();

            $table->unique(['locale', 'group', 'item']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};
