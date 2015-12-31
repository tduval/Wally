<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('historics', function(Blueprint $table) {
  			$table->increments('id');
        $table->integer('account_id')->unsigned();
  			$table->foreign('account_id')->references('id')->on('accounts');
        $table->date('date');
        $table->decimal('investment');
  			$table->decimal('valorisation');
  			$table->decimal('performance');
  			$table->decimal('performancePct');
        $table->decimal('dailyVariation');
        $table->decimal('dailyVariationPCt');
        $table->decimal('cash');
        $table->decimal('indice');
        $table->timestamps();
  			$table->softDeletes();
		  });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::drop('historics');
    }
}
