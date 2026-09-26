<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('email', 254);
            $table->string('company', 160)->nullable();
            $table->string('type', 20);
            $table->string('material', 160)->nullable();
            $table->text('message');
            $table->string('locale', 5)->default('en');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('enquiries'); }
};
