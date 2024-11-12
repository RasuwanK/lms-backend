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
        Schema::table('access_module', function (Blueprint $table) {
            $table->foreign(['Module_Id'], 'access_module_ibfk_1')->references(['Module_Id'])->on('module')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['User_Id'], 'access_module_ibfk_2')->references(['User_Id'])->on('portal_user')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('access_module', function (Blueprint $table) {
            $table->dropForeign('access_module_ibfk_1');
            $table->dropForeign('access_module_ibfk_2');
        });
    }
};
