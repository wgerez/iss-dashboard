<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlumnoslegajosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('alumnoslegajos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('alumno_id')->unsigned();
			$table->foreign('alumno_id')->references('id')->on('alumnos');
			$table->boolean('dni')->default(0);
			$table->boolean('foto')->default(0);
			$table->boolean('partidanacimiento')->default(0);
			$table->boolean('certificadobuenasalud')->default(0);
			$table->boolean('certificadovacinacion')->default(0);
			$table->boolean('fichapreinscripcion')->default(0);
			$table->boolean('titulosecundario')->default(0);
			$table->boolean('constanciatrabajo')->default(0);
			$table->boolean('otros')->default(0);
			$table->string('usuario_alta',50)->nullable();
			$table->timestamp('fecha_alta')->nullable();
			$table->string('usuario_modi',50)->nullable();
			$table->timestamp('fecha_modi')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('alumnoslegajos');
	}

}
