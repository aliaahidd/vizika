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
        Schema::create('vehicleinfo', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('appointmentID');
            $table->string('vehicleType');
            $table->string('vehicleBrand');
            $table->string('vehicleColor');
            $table->string('vehicleRegNo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicleinfo');
    }
};
