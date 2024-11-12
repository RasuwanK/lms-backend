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
        Schema::create('portal_user', function (Blueprint $table) {
            $table->integer('User_Id', true);
            $table->string('Full_Name', 250);
            $table->integer('Age');
            $table->string('Email', 250);
            $table->string('Mobile_No', 20);
            $table->text('Address');
            $table->string('Institution', 200);
            $table->text('Profile_Picture');
            $table->text('Password');
            $table->integer('Role');
            $table->string('Status', 50);
            $table->integer('Course_Id')->index('course_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portal_user');
    }
};
