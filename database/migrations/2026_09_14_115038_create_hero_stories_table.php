<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hero_stories', function (Blueprint $table) {
            $table->id();
            $table->string('label')->nullable();
            $table->string('eyebrow')->nullable();
            $table->string('title_line1')->nullable();
            $table->string('title_line2')->nullable();
            $table->string('accent')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('alt')->nullable();
            $table->string('action_text')->nullable();
            $table->string('action_href')->nullable();
            $table->boolean('is_dark')->default(false);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_stories');
    }
};
