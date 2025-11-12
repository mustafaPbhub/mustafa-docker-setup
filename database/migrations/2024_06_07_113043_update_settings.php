<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if(!Schema::hasTable('website_settings')){
            Schema::create('website_settings', function (Blueprint $table) {
                $table->id();
            $table->string('site_name');
            $table->string('site_url')->default(Request::getHost());
            $table->longText('site_logo');
            $table->longText('favicon');
            $table->timestamps();

            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_settings');
    }
};
