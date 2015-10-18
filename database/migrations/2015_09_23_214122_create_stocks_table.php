<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('stocks', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name');
  			$table->string('type');
  			$table->string('exchange');
  			$table->string('symbol');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::drop('stocks');
    }
}
