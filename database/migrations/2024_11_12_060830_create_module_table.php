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
        Schema::create('module', function (Blueprint $table) {
            $table->integer('Module_Id', true);
            $table->string('Module_Name', 250);
            $table->decimal('Credit_Value', 3, 1);
            $table->integer('Practical_Exam_Count');
            $table->integer('Writing_Exam_Count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module');
    }
};
