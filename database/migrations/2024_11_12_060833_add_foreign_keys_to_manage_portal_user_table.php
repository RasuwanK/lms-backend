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
        Schema::table('manage_portal_user', function (Blueprint $table) {
            $table->foreign(['Admin_Id'], 'manage_portal_user_ibfk_1')->references(['Admin_Id'])->on('admin')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['User_Id'], 'manage_portal_user_ibfk_2')->references(['User_Id'])->on('portal_user')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('manage_portal_user', function (Blueprint $table) {
            $table->dropForeign('manage_portal_user_ibfk_1');
            $table->dropForeign('manage_portal_user_ibfk_2');
        });
    }
};
