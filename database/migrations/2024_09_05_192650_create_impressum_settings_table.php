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
        Schema::create('impressum_settings', function (Blueprint $table) {
            $table->id();
            $table->longText('details');
            $table->longText('address');
            $table->string('email');
            $table->string('phone');
            $table->tinyInteger('is_working_hours')->default(0);
            $table->string('start_day')->nullable();
            $table->string('end_day')->nullable();
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('impressum_settings');
    }
};
