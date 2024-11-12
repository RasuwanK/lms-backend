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
        Schema::create('quiz', function (Blueprint $table) {
            $table->integer('Quiz_Id', true);
            $table->date('Date');
            $table->time('Start_Time');
            $table->time('End_Time');
            $table->integer('Exam_Id')->index('exam_id');

            $table->primary(['Quiz_Id', 'Exam_Id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz');
    }
};
