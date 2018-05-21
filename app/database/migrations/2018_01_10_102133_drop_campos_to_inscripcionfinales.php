<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropCamposToInscripcionfinales extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('inscripcionesfinales', function(Blueprint $table)
		{
			$table->dropForeign(['materia_id']);
			$table->dropColumn('materia_id');
			$table->dropForeign(['docente_id']);
			$table->dropColumn('docente_id');
			$table->dropForeign(['planestudio_id']);
			$table->dropColumn('planestudio_id');
			$table->dropColumn('fecha');
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
