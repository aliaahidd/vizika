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
            $table->string('companyName');
            $table->string('companyRegNo');
            $table->string('companyEmail');
            $table->string('companyPhoneNo');
            $table->string('companyAddress');
            $table->string('companyIndustries');
            $table->string('phonenoPIC');
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
