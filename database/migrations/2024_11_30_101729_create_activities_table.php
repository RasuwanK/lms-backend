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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('activity_name');
            $table->string('type'); // "assignment" or "quiz"
            $table->date('start_date')->nullable(); // Date when the activity starts
            $table->time('start_time')->nullable(); // Time when the activity starts
            $table->date('end_date')->nullable(); // Date when the activity ends
            $table->time('end_time')->nullable(); // Time when the activity ends
            $table->text('instructions')->nullable(); // For assignments
            $table->integer('question_count')->nullable(); // For quizzes
            $table->foreignId('module_id')->constrained('modules')->onDelete('cascade'); // Foreign key to modules
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
