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
            $table->string('portal_user_id')->primary(); // Sepetate user id format will be used
            $table->timestamps();
            $table->integer('age');
            $table->string('email')->unique(); //It is assumed that no users with same email
            $table->string('mobile_no')->unique(); //It is assumed that no users with same email
            $table->string('address');
            $table->string('department_id'); // Seperate department id format will be used 
            $table->string('institution');
            $table->string('profile_picture');
            $table->string('hashed_password');
            $table->string('role');
            $table->string('status');
        });

        Schema::create('department', function (Blueprint $table) {
            $table->string('department_id')->primary(); // Sepetate user id format will be used 
            $table->string('department_name');
            $table->integer('maximum_students');
            $table->integer('department_head');
        });

        Schema::create('portal_user_department', function (Blueprint $table) {
            $table->string('portal_user_id');
            $table->string('department_id');
            $table->foreign('department_id')
                    ->references('department_id')
                     ->on('department');
            $table->foreign('portal_user_id')
                    ->references('portal_user_id')
                     ->on('portal');
            $table->primary(['portal_user_id', 'department_id']);
        });

        Schema::create('admin', function (Blueprint $table) {
            $table->string('admin_id')->primary();
            $table->string('role');
            $table->string('full_name');
            $table->string('email')->unique(); # There can't be multiple admins with same password
            $table->string('mobile_no')->unique(); # There can't be multiple admins with same phone number
        });

        # Bridging between user and admin
        Schema::create('portal_user_admin', function(Blueprint $table) {
            $table->string('admin_id');
            $table->string('portal_user_id');
            $table->foreign('admin_id')
                    ->references('admin_id')
                        ->on('admin');
            $table->foreign('portal_user_id')
                    ->references('portal_user_id')
                        ->on('portal_user');
            $table->primary(['admin_id', 'portal_user_id']);
        });

        Schema::create('department_admin', function(Blueprint $table) {
            $table->string('admin_id');
            $table->string('department_id');
            $table->foreign('admin_id')
                    ->references('admin_id')
                        ->on('admin');
            $table->foreign('department_id')
                    ->references('department_id')
                        ->on('department');
            $table->primary(['admin_id', 'department_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portal_user');
        Schema::dropIfExists('department');
        Schema::dropIfExists('portal_user_department'); 
        Schema::dropIfExists('admin');
        Schema::dropIfExists('portal_user_admin');
        Schema::dropIfExists('department_admin');
    }
};
