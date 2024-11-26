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
            $table->id(); // Primary key: event ID
            $table->unsignedBigInteger('userid'); // Foreign key: User ID
            $table->string('title'); // Title of the event
            $table->text('description')->nullable(); // Event description (optional)
            $table->dateTime('event_date'); // Date and time of the event
            $table->timestamps(); // created_at and updated_at fields

            // Foreign key constraint (assuming users table exists)
            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
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
