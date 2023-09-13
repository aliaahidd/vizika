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
        Schema::create('userchangerequests', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('userID');
            $table->string('original_value');
            $table->string('field_changed');
            $table->string('new_value');
            $table->timestamp('request_date')->useCurrent();
            $table->string('requestStatus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
