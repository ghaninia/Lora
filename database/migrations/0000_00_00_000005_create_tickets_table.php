<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{

    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id() ;
            $table->string('tracking_code') ;

            $table->enum('status' , ['enable' , 'disable'] )->nullable() ;
            $table->boolean('seen')->default(false) ;
            $table->enum('priority' , ['low','medium','hight'])->nullable() ;

            $table->string('from_type') ;
            $table->unsignedBigInteger('from_id') ;

            $table->string('to_type') ;
            $table->unsignedBigInteger('to_id') ;

            $table->string('subject')->nullable();
            $table->text('message') ;

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
