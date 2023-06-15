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
        Schema::create('safetybriefinginfo', function (Blueprint $table) {
            $table->id();
            $table->date('briefingDate');
            $table->time('briefingTimeStart');
            $table->time('briefingTimeEnd');
            $table->bigInteger('maxParticipant');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('safetybriefinginfo');
    }
};
