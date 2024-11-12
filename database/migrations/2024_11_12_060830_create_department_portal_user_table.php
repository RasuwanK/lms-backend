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
        Schema::create('department_portal_user', function (Blueprint $table) {
            $table->integer('Department_Id');
            $table->integer('User_Id')->index('user_id');

            $table->primary(['Department_Id', 'User_Id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('department_portal_user');
    }
};
