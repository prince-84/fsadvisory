<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('communities', function (Blueprint $table) {
            $table->string('h1')->nullable()->after('name');
            $table->string('tagline')->nullable()->after('h1');
            $table->text('short_content')->nullable()->after('tagline');
            $table->longText('full_content')->nullable()->after('short_content');
            $table->json('featured_projects')->nullable()->after('full_content');
            $table->json('faqs')->nullable()->after('featured_projects');
            $table->string('faq_heading')->nullable()->after('faqs');
            $table->string('faq_subtitle')->nullable()->after('faq_heading');
        });

        Schema::table('cities', function (Blueprint $table) {
            $table->string('h1')->nullable()->after('name');
            $table->string('tagline')->nullable()->after('h1');
            $table->text('short_content')->nullable()->after('tagline');
            $table->longText('full_content')->nullable()->after('short_content');
            $table->json('faqs')->nullable()->after('full_content');
            $table->string('faq_heading')->nullable()->after('faqs');
            $table->string('faq_subtitle')->nullable()->after('faq_heading');
        });
    }

    public function down(): void
    {
        Schema::table('communities', function (Blueprint $table) {
            $table->dropColumn(['h1', 'tagline', 'short_content', 'full_content', 'featured_projects', 'faqs', 'faq_heading', 'faq_subtitle']);
        });

        Schema::table('cities', function (Blueprint $table) {
            $table->dropColumn(['h1', 'tagline', 'short_content', 'full_content', 'faqs', 'faq_heading', 'faq_subtitle']);
        });
    }
};
