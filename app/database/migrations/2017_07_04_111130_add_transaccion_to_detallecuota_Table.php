<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTransaccionToDetallecuotaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('detallescuotaspagos', function(Blueprint $table)
		{
			$table->integer('transaccion')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('detallescuotaspagos', function(Blueprint $table)
		{
			//
		});
	}

}
