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
        Schema::table('course_module', function (Blueprint $table) {
            $table->foreign(['Course_Id'], 'course_module_ibfk_1')->references(['Course_Id'])->on('course')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['Module_Id'], 'course_module_ibfk_2')->references(['Module_Id'])->on('module')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_module', function (Blueprint $table) {
            $table->dropForeign('course_module_ibfk_1');
            $table->dropForeign('course_module_ibfk_2');
        });
    }
};
