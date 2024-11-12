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
        Schema::create('access_lecture_material', function (Blueprint $table) {
            $table->integer('User_Id');
            $table->integer('Material_Id')->index('material_id');
            $table->integer('Topic_Id')->index('topic_id');
            $table->integer('Module_Id')->index('module_id');

            $table->primary(['User_Id', 'Material_Id', 'Topic_Id', 'Module_Id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('access_lecture_material');
    }
};
