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
        Schema::table('assignment', function (Blueprint $table) {
            $table->foreign(['Exam_Id'], 'assignment_ibfk_1')->references(['Exam_Id'])->on('exam')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assignment', function (Blueprint $table) {
            $table->dropForeign('assignment_ibfk_1');
        });
    }
};
