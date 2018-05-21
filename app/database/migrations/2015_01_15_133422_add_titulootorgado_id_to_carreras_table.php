<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTitulootorgadoIdToCarrerasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('carreras', function(Blueprint $table)
		{
			$table->integer('titulootorgado_id')->unsigned();
			$table->foreign('titulootorgado_id')->references('id')->on('titulosotorgados');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('carreras', function(Blueprint $table)
		{
			//
		});
	}

}
