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
        Schema::table('department_course', function (Blueprint $table) {
            $table->foreign(['Course_Id'], 'department_course_ibfk_1')->references(['Course_Id'])->on('course')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['Department_Id'], 'department_course_ibfk_2')->references(['Department_Id'])->on('department')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('department_course', function (Blueprint $table) {
            $table->dropForeign('department_course_ibfk_1');
            $table->dropForeign('department_course_ibfk_2');
        });
    }
};
