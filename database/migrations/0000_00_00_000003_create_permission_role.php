<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_role', function (Blueprint $table) {
            $table->unsignedBigInteger("role_id");
            $table->unsignedBigInteger("permission_id");

            $table->index(["role_id", "permission_id"]);

            $table->foreign("role_id")->references("id")->on("roles")->onDelete("cascade");
            $table->foreign("permission_id")->references("id")->on("permissions")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permission_role');
    }
}
