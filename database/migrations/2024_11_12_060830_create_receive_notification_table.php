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
        Schema::create('receive_notification', function (Blueprint $table) {
            $table->integer('User_Id');
            $table->integer('Notification_Id')->index('notification_id');

            $table->primary(['User_Id', 'Notification_Id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receive_notification');
    }
};
