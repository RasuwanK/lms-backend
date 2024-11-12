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
        Schema::table('question', function (Blueprint $table) {
            $table->foreign(['Exam_Id'], 'question_ibfk_1')->references(['Exam_Id'])->on('exam')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['Quiz_Id'], 'question_ibfk_2')->references(['Quiz_Id'])->on('quiz')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('question', function (Blueprint $table) {
            $table->dropForeign('question_ibfk_1');
            $table->dropForeign('question_ibfk_2');
        });
    }
};
