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
        Schema::table('department_portal_user', function (Blueprint $table) {
            $table->foreign(['Department_Id'], 'department_portal_user_ibfk_1')->references(['Department_Id'])->on('department')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['User_Id'], 'department_portal_user_ibfk_2')->references(['User_Id'])->on('portal_user')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('department_portal_user', function (Blueprint $table) {
            $table->dropForeign('department_portal_user_ibfk_1');
            $table->dropForeign('department_portal_user_ibfk_2');
        });
    }
};
