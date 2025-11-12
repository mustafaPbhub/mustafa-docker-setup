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
        Schema::table('stores', function (Blueprint $table) {
            $table->integer('modal')->default(0);
            $table->string('modal_title')->nullable();
            $table->string('modal_description')->nullable();
            $table->string('modal_img')->nullable();
            $table->string('modal_link')->nullable();
        });
        Schema::table('blogs', function (Blueprint $table) {
            $table->integer('modal')->default(0);
            $table->string('modal_title')->nullable();
            $table->string('modal_description')->nullable();
            $table->string('modal_img')->nullable();
            $table->string('modal_link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn('modal');
            $table->dropColumn('modal_title');
            $table->dropColumn('modal_description');
            $table->dropColumn('modal_img');
            $table->dropColumn('modal_link');
        });
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('modal');
            $table->dropColumn('modal_title');
            $table->dropColumn('modal_description');
            $table->dropColumn('modal_img');
            $table->dropColumn('modal_link');
        });
    }
};
