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
        Schema::table('access_lecture_material', function (Blueprint $table) {
            $table->foreign(['Material_Id'], 'access_lecture_material_ibfk_1')->references(['Material_Id'])->on('lecture_material')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['Module_Id'], 'access_lecture_material_ibfk_2')->references(['Module_Id'])->on('module')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['Topic_Id'], 'access_lecture_material_ibfk_3')->references(['Topic_Id'])->on('topic')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['User_Id'], 'access_lecture_material_ibfk_4')->references(['User_Id'])->on('portal_user')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('access_lecture_material', function (Blueprint $table) {
            $table->dropForeign('access_lecture_material_ibfk_1');
            $table->dropForeign('access_lecture_material_ibfk_2');
            $table->dropForeign('access_lecture_material_ibfk_3');
            $table->dropForeign('access_lecture_material_ibfk_4');
        });
    }
};
