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
        Schema::create('slider_ads_banners', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->unsignedBigInteger('store_id');
            $table->longText('link');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->integer('active')->default(0);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slider_ads_banners');
    }
};
