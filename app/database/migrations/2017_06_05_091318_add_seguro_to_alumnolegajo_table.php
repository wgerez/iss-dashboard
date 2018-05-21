<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSeguroToAlumnolegajoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('alumnoslegajos', function(Blueprint $table)
		{
			$table->boolean('seguro')->default(0);
			$table->timestamp('fechavencimientoseguro')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('alumnoslegajos', function(Blueprint $table)
		{
			//
		});
	}

}
