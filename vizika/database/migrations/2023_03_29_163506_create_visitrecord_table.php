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
        Schema::create('visitrecord', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('userID');
            $table->date('checkInDate');
            $table->time('checkInTime');
            $table->date('checkOutDate');
            $table->time('checkOutTime');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitrecord');
    }
};
