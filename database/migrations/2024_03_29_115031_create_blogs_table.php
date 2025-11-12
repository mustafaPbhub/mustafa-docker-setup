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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('slug');
            $table->longText('short_description');
            $table->longText('long_description');
            $table->string('image');
            $table->string('image_alt')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->longText('meta_keywords')->nullable();
            $table->date('published_at');
            $table->integer('published_status')->default(0);
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('store_id');
            $table->integer('home_featured')->default(0);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
