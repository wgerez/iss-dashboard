<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCiclolectivoIdToRegularidadesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('regularidades', function(Blueprint $table)
		{
			$table->integer('ciclolectivo_id')->nullable()->unsigned();
			$table->foreign('ciclolectivo_id')->references('id')->on('cicloslectivos');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('regularidades', function(Blueprint $table)
		{
			//
		});
	}

}
