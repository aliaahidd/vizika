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
        Schema::create('laptopinfo', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('appointmentID');
            $table->string('laptopBrand');
            $table->string('laptopModel');
            $table->string('laptopColor');
            $table->string('laptopSerialNo');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laptopinfo');
    }
};
