<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCamposToInscripcionfinalesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('inscripcionesfinales', function(Blueprint $table)
		{
			$table->integer('mesaexamen_id')->unsigned();
			$table->foreign('mesaexamen_id')->references('id')->on('mesaexamenes');
			$table->boolean('primerllamado')->default(0)->nullable();
			$table->boolean('segundollamado')->default(0)->nullable();
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
