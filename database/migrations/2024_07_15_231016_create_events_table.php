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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('calendar_id');
            $table->string('title');
            $table->text('content')->nullable();
            $table->boolean('is_allday')->default(false)->nullable();
            $table->boolean('is_private')->default(false)->nullable();
            $table->string('state')->nullable();
            $table->string('start');
            $table->string('end');
            $table->string('event_id')->unique()->nullable();
            $table->string('attendees')->nullable();
            $table->string('category')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
