<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegularidadesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('regularidades', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('carrera_id')->nullable()->unsigned();
			$table->foreign('carrera_id')->references('id')->on('carreras');
			$table->integer('planestudio_id')->nullable()->unsigned();
			$table->foreign('planestudio_id')->references('id')->on('planesestudios');
			$table->integer('materia_id')->unsigned();
			$table->foreign('materia_id')->references('id')->on('materias');
			$table->integer('alumno_id')->unsigned();
			$table->foreign('alumno_id')->references('id')->on('alumnos');
			$table->integer('cuatrimestre')->default(0);
			$table->timestamp('fecha_regularidad')->nullable();
			$table->integer('parcial')->nullable();
			$table->integer('calificacion')->nullable();
			$table->integer('nota')->nullable();
			$table->integer('recuperatorio')->nullable();
			$table->integer('regularizo')->nullable();
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
		Schema::drop('regularidades');
	}

}
