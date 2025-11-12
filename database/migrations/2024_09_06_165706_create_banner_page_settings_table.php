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
        Schema::create('banner_page_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('width');
            $table->string('height');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
        Schema::table('coupons', function (Blueprint $table) {
            $table->string('shipping_offer')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banner_page_settings');

        Schema::table('coupons', function (Blueprint $table) {
            $table->string('shipping_offer')->nullable()->change();
        });
    }
};
