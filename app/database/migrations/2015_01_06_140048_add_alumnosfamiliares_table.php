<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAlumnosfamiliaresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('alumnosfamiliares', function(Blueprint $table)
		{
			$table->string('usuario_alta',50)->nullable();
			$table->timestamp('fecha_alta')->nullable();
			$table->string('usuario_modi',50)->nullable();
			$table->timestamp('fecha_modi')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('alumnosfamiliares', function(Blueprint $table)
		{
			$table->dropColumn('usuario_alta');
			$table->dropColumn('fecha_alta');
			$table->dropColumn('usuario_modi');
			$table->dropColumn('fecha_modi');
		});
	}

}
