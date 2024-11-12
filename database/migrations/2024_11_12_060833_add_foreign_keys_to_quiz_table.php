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
        Schema::table('quiz', function (Blueprint $table) {
            $table->foreign(['Exam_Id'], 'quiz_ibfk_1')->references(['Exam_Id'])->on('exam')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quiz', function (Blueprint $table) {
            $table->dropForeign('quiz_ibfk_1');
        });
    }
};
