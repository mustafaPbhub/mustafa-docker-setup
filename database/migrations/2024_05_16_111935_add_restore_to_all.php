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

        // Shops
        Schema::table('stores', function (Blueprint $table) {
            $table->string('deleted_by')->before('created_by')->nullable();
        });

        // Coupons
        Schema::table('coupons', function (Blueprint $table) {
            $table->string('deleted_by')->after('created_by')->nullable();
        });

        // blogs
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('deleted_by')->after('created_by')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        // Shops
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn('deleted_by');
        });

        // Coupons
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn('deleted_by');
        });

        // Blogs
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('deleted_by');
        });

    }
};
