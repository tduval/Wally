<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('transactions', function (Blueprint $table) {
        $table->increments('id');
  			$table->integer('account_id')->unsigned();
  			$table->foreign('account_id')->references('id')->on('accounts');
  			$table->integer('stock_id')->unsigned();
  			$table->foreign('stock_id')->references('id')->on('stocks');
  			$table->string('type');
  			$table->integer('quantity');
  			$table->decimal('price');
  			$table->decimal('commission');
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
      Schema::drop('transactions');
    }
}
