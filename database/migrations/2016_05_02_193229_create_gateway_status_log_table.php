<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateGatewayStatusLogTable extends Migration
{

    function getTable()
    {
        return config('gateway.table','gateway_transactions');
    }

    function getLogTable()
    {
        return $this->getTable().'_logs';
    }
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->getLogTable(), function (Blueprint $table) {
            $table->engine="innoDB";
            $table->increments('id');
            $table->unsignedBigInteger('transaction_id'); 
            $table->string('result_code', 10)->nullable();
            $table->string('result_message', 255)->nullable();
            $table->timestamp('log_date')->nullable();

            $table
                ->foreign('transaction_id')
                ->references('id')
                ->on($this->getTable())
                ->onDelete('cascade');
        });

        try {
            DB::statement("ALTER TABLE  `" . $this->getLogTable() . "` drop foreign key transactions_logs_transaction_id_foreign;");
            DB::statement("ALTER TABLE  `" . $this->getLogTable() . "` DROP INDEX transactions_logs_transaction_id_foreign;");
        } catch (Exception $e) {

        }

        try {
            DB::statement("update `" . $this->getTable() . "` set `payment_date`=null WHERE  `payment_date`=0;");
            DB::statement("ALTER TABLE `" . $this->getTable() . "` CHANGE `id` `id` BIGINT UNSIGNED NOT NULL;");
            DB::statement("ALTER TABLE `" . $this->getLogTable() . "` CHANGE `transaction_id` `transaction_id` BIGINT UNSIGNED NOT NULL;");
            DB::statement("ALTER TABLE  `" . $this->getLogTable() . "` ADD INDEX `transactions_logs_transaction_id_foreign` (`transaction_id`);");
        } catch (Exception $e) {

        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop($this->getLogTable());
        // Don't check for foreign key constraints when executing below query in current session
        DB::statement('set foreign_key_checks=0');

        DB::statement("ALTER TABLE `" . $this->getTable() . "` CHANGE `id` `id` INT(10) UNSIGNED NOT NULL;");

        // Ok! now DBMS can check for foregin key constraints
        DB::statement('set foreign_key_checks=1');
    }
}
