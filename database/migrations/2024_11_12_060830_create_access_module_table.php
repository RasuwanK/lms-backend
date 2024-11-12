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
        Schema::create('access_module', function (Blueprint $table) {
            $table->integer('User_Id');
            $table->integer('Module_Id')->index('module_id');

            $table->primary(['User_Id', 'Module_Id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('access_module');
    }
};
