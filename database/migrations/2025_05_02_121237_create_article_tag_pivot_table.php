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
        Schema::create('faq_article_faq_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('faq_article_id');

            $table->foreign('faq_article_id', 'article_id_fk_455948')->references('id')->on('faq_articles')->onDelete('cascade');

            $table->unsignedBigInteger('faq_tag_id');

            $table->foreign('faq_tag_id', 'tag_id_fk_455948')->references('id')->on('faq_tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_tag_pivot');
    }
};
