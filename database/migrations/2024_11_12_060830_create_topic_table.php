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
        Schema::create('topic', function (Blueprint $table) {
            $table->integer('Topic_Id', true);
            $table->string('Topic_Name', 250);
            $table->string('Type', 100);
            $table->boolean('Is_Complete');
            $table->integer('Module_Id')->index('module_id');
            $table->integer('User_Id')->index('user_id');

            $table->primary(['Topic_Id', 'Module_Id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topic');
    }
};
