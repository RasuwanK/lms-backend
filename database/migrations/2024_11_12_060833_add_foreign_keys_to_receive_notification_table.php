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
        Schema::table('receive_notification', function (Blueprint $table) {
            $table->foreign(['Notification_Id'], 'receive_notification_ibfk_1')->references(['Notification_Id'])->on('notification')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['User_Id'], 'receive_notification_ibfk_2')->references(['User_Id'])->on('portal_user')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('receive_notification', function (Blueprint $table) {
            $table->dropForeign('receive_notification_ibfk_1');
            $table->dropForeign('receive_notification_ibfk_2');
        });
    }
};
