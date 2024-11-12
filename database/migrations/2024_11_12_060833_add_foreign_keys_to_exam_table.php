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
        Schema::table('exam', function (Blueprint $table) {
            $table->foreign(['Module_Id'], 'exam_ibfk_1')->references(['Module_Id'])->on('module')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['User_Id'], 'exam_ibfk_2')->references(['User_Id'])->on('portal_user')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['Event_Id'], 'exam_ibfk_3')->references(['Event_Id'])->on('event')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exam', function (Blueprint $table) {
            $table->dropForeign('exam_ibfk_1');
            $table->dropForeign('exam_ibfk_2');
            $table->dropForeign('exam_ibfk_3');
        });
    }
};
