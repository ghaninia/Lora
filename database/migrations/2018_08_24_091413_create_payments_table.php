<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Larabookir\Gateway\Enum;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('discount_id')->nullable() ;
            $table->unsignedInteger("user_id")->nullable() ;
            $table->float('amount' , 10 , 2 ) ;
            $table->string('ref_id', 100)->nullable() ;
            $table->string('tracking_code', 50)->nullable()  ;
            $table->string('transaction_id')->nullable() ;

            $table->enum('status', [
                Enum::TRANSACTION_INIT,
                Enum::TRANSACTION_SUCCEED,
                Enum::TRANSACTION_FAILED
            ])->default(Enum::TRANSACTION_INIT);

            $table->timestamps();

            $table->foreign('discount_id')->on("discounts")->references("id")->onDelete('cascade')->onUpdate('cascade') ;
            $table->foreign('user_id')->on("users")->references("id")->onDelete('cascade')->onUpdate('cascade') ;

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
