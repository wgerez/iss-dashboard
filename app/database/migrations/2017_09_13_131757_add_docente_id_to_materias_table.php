<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDocenteIdToMateriasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('materias', function(Blueprint $table)
		{
			$table->integer('docente_id')->unsigned()->nullable();
			$table->foreign('docente_id')->references('id')->on('docentes');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('materias', function(Blueprint $table)
		{
			$table->dropColumn('docente_id');
		});
	}

}
