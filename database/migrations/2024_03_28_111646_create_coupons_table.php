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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id');
            $table->string('offer_name');
            $table->string('offer_box');
            $table->longtext('tracking_url')->nullable();
            $table->string('coupon_code')->nullable();
            $table->integer('coupon_type')->default(0);
            $table->integer('featured_for_home')->default(0);
            $table->integer('flicker_button')->default(0);
            $table->integer('verified_button')->default(0);
            $table->integer('exclusive_button')->default(0);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->date('expiry_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
