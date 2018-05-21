<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCamposToExamenfinal extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('examenfinal', function(Blueprint $table)
		{
			$table->integer('inscripcionfinal_id')->unsigned();
			$table->foreign('inscripcionfinal_id')->references('id')->on('inscripcionesfinales');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('examenfinal', function(Blueprint $table)
		{
			//
		});
	}

}
