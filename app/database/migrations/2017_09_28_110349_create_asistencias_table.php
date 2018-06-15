<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsistenciasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('asistencias', function(Blueprint $table)
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
			$table->integer('docente_id')->unsigned();
			$table->foreign('docente_id')->references('id')->on('docentes');
			$table->timestamp('lunesfecha')->nullable();
			$table->integer('lunes')->default(0);
			$table->timestamp('martesfecha')->nullable();
			$table->integer('martes')->default(0);
			$table->timestamp('miercolesfecha')->nullable();
			$table->integer('miercoles')->default(0);
			$table->timestamp('juevesfecha')->nullable();
			$table->integer('jueves')->default(0);
			$table->timestamp('viernesfecha')->nullable();
			$table->integer('viernes')->default(0);
			$table->timestamp('sabadofecha')->nullable();
			$table->integer('sabado')->default(0);
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
		Schema::drop('asistencias');
	}

}
