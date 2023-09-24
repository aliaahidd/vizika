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
        Schema::create('companyinfo', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('userID');
            $table->bigInteger('staffID');
            $table->string('mngtPICName');
            $table->string('mngtPICEmail');
            $table->string('safetyPICName');
            $table->string('safetyPICEmail');
            $table->string('companyName');
            $table->string('companyRegNo');
            $table->string('companyEmail');
            $table->string('companyPhoneNo');
            $table->string('companyAddress');
            $table->string('companyIndustries');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companyinfo');
    }
};
