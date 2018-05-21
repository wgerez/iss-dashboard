<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNrolegajohabilitanteToDocentesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('docentes', function(Blueprint $table)
		{
			DB::statement('ALTER TABLE `docentes` MODIFY `nrolegajohabilitante` varchar(20) NULL;');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('docentes', function(Blueprint $table)
		{
			DB::statement('ALTER TABLE `docentes` MODIFY `nrolegajohabilitante` integer NULL;');
		});
	}

}
