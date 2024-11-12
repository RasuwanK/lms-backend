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
        Schema::create('manage_dept', function (Blueprint $table) {
            $table->integer('Admin_Id');
            $table->integer('Department_Id')->index('department_id');

            $table->primary(['Admin_Id', 'Department_Id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manage_dept');
    }
};
