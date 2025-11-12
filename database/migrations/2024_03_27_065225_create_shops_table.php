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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('heading')->nullable();
            $table->unsignedBigInteger('category')->nullable();
            $table->string('image')->nullable();
            $table->string('image_alt');
            $table->longText('direct_url');
            $table->longText('tracking_url');
            $table->string('meta_title');
            $table->longText('meta_description');
            $table->longText('meta_keywords')->nullable();
            $table->longText('short_description');
            $table->longText('long_description');
            $table->integer('top_stores')->default(0);
            $table->integer('editor_choice')->default(0);
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
        Schema::dropIfExists('stores');
    }
};
