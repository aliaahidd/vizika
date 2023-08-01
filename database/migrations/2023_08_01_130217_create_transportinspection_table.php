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
        Schema::create('transportinspection', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('companyID');
            $table->date('visitDate');
            $table->string('vehicleRegNo');
            $table->string('primeMoverInside');
            $table->string('primeMoverBack');
            $table->string('trailerUnder');
            $table->string('trailerBehind');
            $table->string('trailerLeft');
            $table->string('trailerRight');
            $table->string('security');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transportinspection');
    }
};
