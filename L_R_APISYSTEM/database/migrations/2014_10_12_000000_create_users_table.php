<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->integer('mobile')->nullable();
            $table->integer('otp')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->default('admin');
            $table->integer('login_mode')->default(0)->comment('1 - Normal, 2 - Google, 3 - Facebook');
            $table->integer('reg_status')->default(0)->comment('0 - In progress, 1 - Completed');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}