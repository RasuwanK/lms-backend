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
        Schema::create('assignment', function (Blueprint $table) {
            $table->integer('Assignment_Id', true);
            $table->text('Description');
            $table->date('Given_Date');
            $table->date('Dead_Line');
            $table->text('Material');
            $table->integer('Exam_Id')->index('exam_id');

            $table->primary(['Assignment_Id', 'Exam_Id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignment');
    }
};
