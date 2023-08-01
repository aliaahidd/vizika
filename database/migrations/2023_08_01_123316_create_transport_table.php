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
        Schema::create('transport', function (Blueprint $table) {
            $table->id();
            $table->date('visitDate');
            $table->bigInteger('companyID');
            $table->string('vehicleRegNo');
            $table->string('contractorID');
            $table->string('plant');
            $table->string('passNo');
            $table->time('checkInTime');
            $table->time('checkOutTime')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transport');
    }
};
