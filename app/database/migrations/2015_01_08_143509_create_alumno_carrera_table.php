<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlumnoCarreraTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('alumno_carrera', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('alumno_id')->unsigned();
			$table->foreign('alumno_id')->references('id')->on('alumnos');
			$table->integer('carrera_id')->nullable()->unsigned();
			$table->foreign('carrera_id')->references('id')->on('carreras');
			$table->integer('ciclolectivo_id')->nullable()->unsigned();
			$table->foreign('ciclolectivo_id')->references('id')->on('cicloslectivos');
			$table->boolean('activo')->default(1);
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
		Schema::drop('alumno_carrera');
	}

}
