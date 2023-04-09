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
        Schema::create('contractorinfo', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('userID');
            $table->string('companyName');
            $table->string('phoneNo');
            $table->date('passExpiryDate');
            $table->date('birthDate');
            $table->string('address');
            $table->string('passportPhoto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contractorinfo');
    }
};
