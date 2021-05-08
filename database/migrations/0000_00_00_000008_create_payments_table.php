<?php

use App\Enum\PaymentEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->id() ;
            $table->unsignedBigInteger('discount_id')->nullable() ;
            $table->unsignedBigInteger("user_id")->nullable() ;
            $table->float('amount' , 10 , 2 ) ;
            $table->string('ref_id', 100)->nullable() ;
            $table->string('tracking_code', 50)->nullable()  ;
            $table->unsignedBigInteger('transaction_id')->nullable() ;

            $table->enum('status', [
                PaymentEnum::TRANSACTION_INIT,
                PaymentEnum::TRANSACTION_SUCCEED,
                PaymentEnum::TRANSACTION_FAILED
            ])->default(PaymentEnum::TRANSACTION_INIT);

            $table->timestamps();

            $table->index([
                "discount_id" ,
                "user_id" ,
            ]) ;

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
