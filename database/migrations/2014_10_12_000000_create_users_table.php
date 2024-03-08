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
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('mobile')->unique();
            $table->tinyInteger('gender')->default(0)->comment('0 => male, 1 => famale');
            $table->tinyInteger('service_status')->nullable()->comment('0 => Continuing education, 1 => Exemption, 2 => the end of service');
            $table->text('address');
            $table->string('national_code')->unique()->nullable()->comment("code meli");
            $table->text('profile_photo_path')->nullable()->comment("avatar");
            $table->tinyInteger('user_type')->default(0)->comment("to find out if the user is an admin or a regular user (0 => user, 1 => admin) ");
            $table->timestamp('activation_date')->nullable()->comment('get user activity time');
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('mobile_verified_at')->nullable();
            $table->string('username');
            $table->string('password');
            $table->rememberToken();
            $table->tinyInteger('status')->default(0)->comment('0 => inactive and does not have access, 1 => active and does have access');
            $table->timestamps();
            $table->softDeletes();
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
