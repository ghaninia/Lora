<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->unsignedBigInteger("role_id")->nullable();
            $table->float('credit', 15, 2)->default(0);
            $table->boolean('status')->default(true);
            $table->string("firstname")->nullable();
            $table->string("lastname")->nullable();
            $table->string("username", 255)->unique()->nullable();
            $table->string("mobile", 11)->unique();
            $table->string("email", 255)->unique()->nullable();
            $table->enum("gender", ['male', 'female'])->default('male');
            $table->string("theme")->default('yellow');
            $table->text("picture")->nullable();
            $table->rememberToken();
            $table->string("password");
            $table->timestamps();

            $table->foreign("role_id")->references("id")->on("roles")->onDelete("SET NULL");
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
