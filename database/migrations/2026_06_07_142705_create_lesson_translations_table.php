<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lesson_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained()->cascadeOnDelete();
            $table->string('locale', 10)->index();
            $table->string('title');
            $table->longText('content')->nullable();
            $table->timestamps();

            $table->unique(['lesson_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lesson_translations');
    }
};
