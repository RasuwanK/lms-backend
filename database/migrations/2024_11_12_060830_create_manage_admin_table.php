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
        Schema::create('manage_admin', function (Blueprint $table) {
            $table->integer('Admin_Id');
            $table->integer('Super_Admin_Id')->index('super_admin_id');

            $table->primary(['Admin_Id', 'Super_Admin_Id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manage_admin');
    }
};
