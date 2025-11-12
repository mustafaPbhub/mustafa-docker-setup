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
        if(Schema::hasColumn('coupons','tracking_url')){
            Schema::table('coupons', function(Blueprint $blueprint){
                $blueprint->dropColumn('tracking_url');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(!Schema::hasColumn('coupons','tracking_url')){
            Schema::table('coupons', function(Blueprint $blueprint){
                $blueprint->longText('tracking_url');
            });
        }
    }
};
