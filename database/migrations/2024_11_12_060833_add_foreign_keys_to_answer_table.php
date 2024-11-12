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
        Schema::table('answer', function (Blueprint $table) {
            $table->foreign(['Announcement_Id'], 'answer_ibfk_1')->references(['Announcement_Id'])->on('announcement')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('answer', function (Blueprint $table) {
            $table->dropForeign('answer_ibfk_1');
        });
    }
};
