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
        Schema::table('coupons', function (Blueprint $table) {
            $table->integer('sort_order')->default(0)->before('updated_at');
            $table->longText("description")->nullable();
            $table->integer("no_clicks")->default(0)->before('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn('sort_order');
            $table->dropColumn("description");
            $table->dropColumn("no_clicks");
        });
    }
};
