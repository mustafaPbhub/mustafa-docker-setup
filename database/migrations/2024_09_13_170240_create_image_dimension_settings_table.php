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
        Schema::create('image_dimension_settings', function (Blueprint $table) {
            $table->id();
            $table->string('module');
            $table->integer('width');
            $table->integer('height');
            $table->tinyInteger('exclusive_coupon_card')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image_dimension_settings');
    }
};
