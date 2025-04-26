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
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('author_id');
            $table->string('blog_post_name');
            $table->string('slug')
                ->nullable();
            $table->string('blog_post_url')
                ->nullable();
            $table->text('blog_post_content');
            $table->string('thumbnail_path')
                ->nullable();
            $table->timestamps();
            
            $table->foreign('author_id')
            ->references('id')
            ->on('blog_authors');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
