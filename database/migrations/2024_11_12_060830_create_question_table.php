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
        Schema::create('question', function (Blueprint $table) {
            $table->integer('Question_Number', true);
            $table->integer('Quiz_Id')->index('quiz_id');
            $table->integer('Exam_Id')->index('exam_id');
            $table->text('Question');
            $table->text('Answer');

            $table->primary(['Question_Number', 'Quiz_Id', 'Exam_Id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question');
    }
};
