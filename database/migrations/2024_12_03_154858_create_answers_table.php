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
        Schema::create('answers', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('announcement_id')->constrained('announcements')->onDelete('cascade'); // Foreign Key to Announcements
            $table->foreignId('user_id')->constrained('portal_users')->onDelete('cascade'); // Foreign Key to Portal Users
            $table->text('description'); // Answer content
            $table->timestamps(); // Includes created_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
