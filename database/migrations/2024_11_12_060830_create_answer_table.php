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
        Schema::create('answer', function (Blueprint $table) {
            $table->integer('Answer_Number', true);
            $table->integer('Announcement_Id')->index('announcement_id');
            $table->text('Description');

            $table->primary(['Answer_Number', 'Announcement_Id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answer');
    }
};
