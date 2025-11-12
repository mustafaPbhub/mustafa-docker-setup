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
        Schema::table('offers', function (Blueprint $table){
            $table->string('bottom_offer')->nullable()->change();
        });
        Schema::table('subscribers', function (Blueprint $table){
            $table->string('ip_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscribers', function (Blueprint $table){
            $table->dropColumn('ip_address');
        });
    }
};
