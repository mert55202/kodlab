<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->nullable()->after('name');
            $table->text('bio')->nullable()->after('email');
            $table->string('avatar')->nullable()->after('bio');
            $table->string('website')->nullable()->after('avatar');
            $table->string('github')->nullable()->after('website');
            $table->string('twitter')->nullable()->after('github');
            $table->string('linkedin')->nullable()->after('twitter');
            $table->string('education_level')->nullable()->after('linkedin');
            $table->string('preferred_language', 10)->default('tr')->after('education_level');
            $table->string('theme', 20)->default('light')->after('preferred_language');
            $table->integer('total_points')->default(0)->after('theme');
            $table->boolean('is_premium')->default(false)->after('total_points');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username', 'bio', 'avatar', 'website', 'github', 
                'twitter', 'linkedin', 'education_level', 
                'preferred_language', 'theme', 'total_points', 'is_premium'
            ]);
        });
    }
};
