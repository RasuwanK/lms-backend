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
        Schema::create('exam', function (Blueprint $table) {
            $table->integer('Exam_Id', true);
            $table->string('Exam_Name', 250);
            $table->string('Type', 100);
            $table->decimal('Mark', 5);
            $table->text('Description');
            $table->integer('Module_Id')->index('module_id');
            $table->integer('User_Id')->index('user_id');
            $table->integer('Event_Id')->index('event_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam');
    }
};
