<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAnularToInscripcionfinales extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('inscripcionesfinales', function(Blueprint $table)
		{
			$table->boolean('anulado')->default(0);
			$table->string('usuario_anula',50)->nullable();
			$table->timestamp('fecha_anulacion')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('inscripcionesfinales', function(Blueprint $table)
		{
			//
		});
	}

}
