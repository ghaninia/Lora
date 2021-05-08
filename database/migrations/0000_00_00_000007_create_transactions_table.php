<?php

use App\Enum\PaymentEnum;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create("transactions", function (Blueprint $table) {
            $table->id();
            $table->string('port')->nullable();
            $table->decimal('price', 15, 2);
            $table->string('ref_id', 100)->nullable();
            $table->string('tracking_code', 50)->nullable();
            $table->string('card_number', 50)->nullable();
            
            $table->enum('status', [
                PaymentEnum::TRANSACTION_INIT,
                PaymentEnum::TRANSACTION_SUCCEED,
                PaymentEnum::TRANSACTION_FAILED,
            ])->default(PaymentEnum::TRANSACTION_INIT);

            $table->string('ip', 20)->nullable();
            $table->text("description")->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->nullableTimestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop("transactions");
    }
}
