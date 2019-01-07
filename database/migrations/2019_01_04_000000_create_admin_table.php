<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTable extends Migration
{
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
           $table->increments('id');
           $table->string('name', 80)->nullable();
           $table->string('username', 60)->unique();
           $table->string('email', 60)->unique();
           $table->string('mobile', 20)->nullable();
           $table->string('password');
           $table->string('avatar')->nullable();
           $table->text('accessToken')->nullable();
           $table->boolean('state')->default(true);
           $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('admin');
    }
}
