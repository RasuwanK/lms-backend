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
        Schema::table('lecture_material', function (Blueprint $table) {
            $table->foreign(['Topic_Id'], 'lecture_material_ibfk_1')->references(['Topic_Id'])->on('topic')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['Module_Id'], 'lecture_material_ibfk_2')->references(['Module_Id'])->on('module')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['User_Id'], 'lecture_material_ibfk_3')->references(['User_Id'])->on('portal_user')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lecture_material', function (Blueprint $table) {
            $table->dropForeign('lecture_material_ibfk_1');
            $table->dropForeign('lecture_material_ibfk_2');
            $table->dropForeign('lecture_material_ibfk_3');
        });
    }
};
