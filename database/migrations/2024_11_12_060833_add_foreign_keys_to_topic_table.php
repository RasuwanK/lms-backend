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
        Schema::table('topic', function (Blueprint $table) {
            $table->foreign(['User_Id'], 'topic_ibfk_1')->references(['User_Id'])->on('portal_user')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['Module_Id'], 'topic_ibfk_2')->references(['Module_Id'])->on('module')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('topic', function (Blueprint $table) {
            $table->dropForeign('topic_ibfk_1');
            $table->dropForeign('topic_ibfk_2');
        });
    }
};
