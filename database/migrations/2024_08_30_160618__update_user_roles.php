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
       Schema::table('user_accesses', function(Blueprint $table){
            $table->dropColumn('user_id');
            $table->tinyInteger('role_id')->after('id');
       });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_accesses', function(Blueprint $table){
            $table->tinyInteger('user_id')->after('id');
            $table->dropColumn('role_id');
       });
    }
};
