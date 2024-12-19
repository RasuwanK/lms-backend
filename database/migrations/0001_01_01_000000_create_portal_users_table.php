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
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('course_name');
            $table->integer('credit_value')->nullable();
            $table->integer('maximum_students')->nullable();
            $table->foreignId('department_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('portal_users', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->string('Full_name'); // Full name
            $table->unsignedTinyInteger('Age')->nullable(); // Age (unsigned, optional)
            $table->string('Email')->unique(); // Email (unique and required)
            $table->string('Mobile_No', 15)->unique()->nullable(); // Mobile number (optional and unique)
            $table->text('Address')->nullable(); // Address (optional)
            $table->string('Institution')->nullable(); // Institution name (optional)
            $table->string('Profile_Picture')->nullable(); // Profile picture URL
            $table->string('Password'); // Password (hashed)
            $table->string('Role'); // User role (e.g., admin, student, etc.)
            $table->boolean('Status')->default(1); // Status (active by default)
            $table->unsignedBigInteger('Course_Id')->nullable(); // Foreign key to courses table
            $table->timestamps(); // Created at and updated at fields

            // Foreign key constraint
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('set null');
        });

        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id')->constrained('portal_users');
            $table->string('title');
            $table->text('description');
            $table->dateTime('event_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portal_users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('courses');
    }
};
