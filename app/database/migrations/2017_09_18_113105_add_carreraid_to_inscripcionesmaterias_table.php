<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCarreraidToInscripcionesmateriasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('inscripcionesmaterias', function(Blueprint $table)
		{
			$table->integer('carrera_id')->nullable()->unsigned();
			$table->foreign('carrera_id')->references('id')->on('carreras');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('inscripcionesmaterias', function(Blueprint $table)
		{
			//
		});
	}

}
