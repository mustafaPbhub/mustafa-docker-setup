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
      Schema::table('blogs', function(Blueprint $table){
        $table->string('color')->default('transparent')->after('title');
      });
      Schema::table('image_dimension_settings' , function(Blueprint $table){
        $table->tinyInteger('is_color_available')->default(0)->after('exclusive_coupon_card');
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogs', function(Blueprint $table){
            $table->dropColumn('color');
        });
        Schema::table('image_dimension_settings' , function(Blueprint $table){
             $table->dropColumn('is_color_available');
        });
    }
};
