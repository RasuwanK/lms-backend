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
        Schema::create('lecture_material', function (Blueprint $table) {
            $table->integer('Material_Id', true);
            $table->string('Name', 250);
            $table->string('Type', 50);
            $table->text('Link');
            $table->integer('Topic_Id')->index('topic_id');
            $table->integer('Module_Id')->index('module_id');
            $table->integer('User_Id')->index('user_id');

            $table->primary(['Material_Id', 'Topic_Id', 'Module_Id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecture_material');
    }
};
