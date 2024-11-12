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
        Schema::table('portal_user', function (Blueprint $table) {
            $table->foreign(['Course_Id'], 'portal_user_ibfk_1')->references(['Course_Id'])->on('course')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('portal_user', function (Blueprint $table) {
            $table->dropForeign('portal_user_ibfk_1');
        });
    }
};
