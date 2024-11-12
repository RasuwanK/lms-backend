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
        Schema::table('manage_admin', function (Blueprint $table) {
            $table->foreign(['Admin_Id'], 'manage_admin_ibfk_1')->references(['Admin_Id'])->on('admin')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['Super_Admin_Id'], 'manage_admin_ibfk_2')->references(['Admin_Id'])->on('admin')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('manage_admin', function (Blueprint $table) {
            $table->dropForeign('manage_admin_ibfk_1');
            $table->dropForeign('manage_admin_ibfk_2');
        });
    }
};
