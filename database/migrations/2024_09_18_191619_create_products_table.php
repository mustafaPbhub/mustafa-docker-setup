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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id')->nullable();
            $table->unsignedBigInteger(column: 'category_id');
            $table->string('name');
            $table->longText('slug');
            $table->string('image');
            $table->string('image_alt');
            $table->integer('price');
            $table->integer('is_discount')->default(0);
            $table->integer('discounted_amount')->nullable();
            $table->mediumText('short_description');
            $table->longText('long_description');
            $table->string('created_by');
            $table->string('meta_title');
            $table->string('meta_description');
            $table->string('meta_keywords')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
