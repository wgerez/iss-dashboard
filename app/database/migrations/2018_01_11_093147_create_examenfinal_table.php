<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamenfinalTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('examenfinal', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('organizacion_id')->unsigned();
			$table->foreign('organizacion_id')->references('id')->on('organizaciones');
			$table->integer('carrera_id')->nullable()->unsigned();
			$table->foreign('carrera_id')->references('id')->on('carreras');
			$table->integer('planestudio_id')->nullable()->unsigned();
			$table->foreign('planestudio_id')->references('id')->on('planesestudios');
			$table->integer('turnoexamen_id')->unsigned();
			$table->foreign('turnoexamen_id')->references('id')->on('turnoexamenes');
			$table->integer('materia_id')->unsigned();
			$table->foreign('materia_id')->references('id')->on('materias');
			$table->integer('alumno_id')->unsigned();
			$table->foreign('alumno_id')->references('id')->on('alumnos');
			$table->string('libro',300)->nullable();
			$table->string('folio',300)->nullable();
			$table->string('acta',300)->nullable();
			$table->integer('calif_final_num')->nullable();
			$table->string('calif_final_let', 100)->nullable();
			$table->timestamp('fecha_aprobacion')->nullable();
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
		Schema::drop('examenfinal');
	}

}
