<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAsistenciaJustificaToExamenfinalTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('examenfinal', function(Blueprint $table)
		{
			$table->boolean('asistencia')->default(0);
			$table->boolean('justifico')->default(0);
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
