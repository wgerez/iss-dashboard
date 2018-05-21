<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlumnosfamiliaresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('alumnosfamiliares', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('persona_id')->unsigned();
			$table->foreign('persona_id')->references('id')->on('personas');
			$table->integer('alumno_id')->unsigned();
			$table->foreign('alumno_id')->references('id')->on('alumnos');
			$table->integer('relacionfamiliar_id')->unsigned();
			$table->foreign('relacionfamiliar_id')->references('id')->on('relacionesfamiliares');
			$table->boolean('responsable')->default(0);
			$table->integer('ocupacion_id')->unsigned()->nullable();
			$table->foreign('ocupacion_id')->references('id')->on('ocupaciones');
			$table->string('lugartrabajoestudio')->nullable();
			$table->boolean('enfermedaddiscapacidad')->default(0);
			$table->string('enfermedaddiscapacidaddetalle')->nullable();
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
		Schema::drop('alumnosfamiliares');
	}

}
