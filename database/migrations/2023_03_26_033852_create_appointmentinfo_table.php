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
        Schema::create('appointmentinfo', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('staffID');
            $table->bigInteger('contVisitID');
            $table->string('appointmentPurpose');
            $table->string('appointmentAgenda');
            $table->date('appointmentDate');
            $table->time('appointmentTime');
            $table->string('bringVehicle');
            $table->string('bringLaptop');
            $table->string('appointmentStatus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointmentinfo');
    }
};
