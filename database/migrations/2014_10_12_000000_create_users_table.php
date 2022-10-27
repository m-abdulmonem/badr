<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->string('full_name');
            $table->string("f_name")->comment("first name of user");
            $table->string("l_name")->comment("last name of user");
            $table->string("m_name")->nullable()->comment("middle name of user");
            $table->integer("otp_code")->nullable();
            $table->string("phone");
            $table->integer("is_admin")->default(0)->comment("is value 1 this user is admin");
            $table->integer("status")->default(0)->comment("is value 1 this user is active");
            $table->string("drive_license")->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
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
};
