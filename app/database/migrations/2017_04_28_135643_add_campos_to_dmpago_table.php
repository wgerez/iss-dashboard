<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCamposToDmpagoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('detallesmatriculaspagos', function(Blueprint $table)
		{
			$table->decimal('importeparcial',8,2)->nullable();
			$table->decimal('saldo',8,2)->nullable();
			$table->decimal('efectivo',8,2)->nullable();
			$table->decimal('tarjetacredito',8,2)->nullable();
			$table->decimal('tarjetadebito',8,2)->nullable();
			$table->decimal('cuentabancaria',8,2)->nullable();
			$table->boolean('totalparcial')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('detallesmatriculaspagos', function(Blueprint $table)
		{
			//
		});
	}

}
