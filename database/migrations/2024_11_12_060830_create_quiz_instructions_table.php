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
        Schema::create('quiz_instructions', function (Blueprint $table) {
            $table->integer('Quiz_Id');
            $table->integer('Exam_Id')->index('exam_id');
            $table->text('Instructions');

            $table->primary(['Quiz_Id', 'Exam_Id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_instructions');
    }
};
