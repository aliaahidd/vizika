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
        Schema::create('visitorqrscan', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phoneNo');
            $table->string('companyName');
            $table->string('employeeNo');
            $table->string('occupation');
            $table->string('visitPurpose');
            $table->string('passNo')->nullable();
            $table->date('checkInDate');
            $table->time('checkInTime');
            $table->date('checkOutDate')->nullable();
            $table->time('checkOutTime')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitorqrscan');
    }
};