<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCamposToCajachicaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cajachica', function(Blueprint $table)
		{
			$table->decimal('efectivo',8,2)->nullable();
			$table->decimal('tarjetacredito',8,2)->nullable();
			$table->decimal('tarjetadebito',8,2)->nullable();
			$table->decimal('cuentabancaria',8,2)->nullable();
			$table->decimal('cheque',8,2)->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cajachica', function(Blueprint $table)
		{
			//
		});
	}

}
