<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ad_settings', function (Blueprint $table) {
            $table->id();
            $table->string('adsense_publisher_id')->nullable();
            $table->boolean('ads_enabled')->default(false);
            $table->boolean('show_in_header')->default(false);
            $table->boolean('show_in_sidebar')->default(false);
            $table->boolean('show_in_lesson')->default(false);
            $table->boolean('show_in_quiz')->default(false);
            $table->boolean('hide_for_premium')->default(true);
            $table->string('ad_slot_header')->nullable();
            $table->string('ad_slot_sidebar')->nullable();
            $table->string('ad_slot_lesson')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ad_settings');
    }
};
