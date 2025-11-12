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
        Schema::table('impressums', function(Blueprint $table){
            $table->mediumText('ip_address')->nullable()->after('is_consent');
            $table->mediumText('mac_address')->nullable()->after('is_consent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('impressums', function(Blueprint $table){
            $table->dropColumn('ip_address');
            $table->dropColumn('mac_address');
        });
    }
};
