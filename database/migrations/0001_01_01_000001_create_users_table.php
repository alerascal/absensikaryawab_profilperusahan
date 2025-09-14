<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role')->default('employee'); // admin, employee
            $table->unsignedBigInteger('department_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('employee_id')->unique()->nullable();
            $table->string('position')->nullable();
            $table->string('employment_status')->nullable(); // full-time, part-time, contract, etc.
            $table->date('join_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}