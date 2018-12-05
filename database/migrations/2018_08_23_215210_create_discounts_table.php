<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean("status")->default(TRUE) ;
            $table->integer('percent')->default(0) ; // darsad
            $table->float('amount')->default(0) ; // meghdar sabet
            $table->string('code')->unique() ;
            $table->integer('number_of_use')->default(1) ;
            $table->text('description') ;
            $table->date("expired_at") ;
            $table->timestamps() ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discounts');
    }
}
