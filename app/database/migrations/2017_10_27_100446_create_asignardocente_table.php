<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsignardocenteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('asignardocente', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('carrera_id')->nullable()->unsigned();
			$table->foreign('carrera_id')->references('id')->on('carreras');
			$table->integer('planestudio_id')->nullable()->unsigned();
			$table->foreign('planestudio_id')->references('id')->on('planesestudios');
			$table->integer('materia_id')->nullable()->unsigned();
			$table->foreign('materia_id')->references('id')->on('materias');
			$table->integer('docentetitular_id')->nullable()->unsigned();
			$table->foreign('docentetitular_id')->references('id')->on('docentes');
			$table->integer('docenteprovisorio_id')->nullable()->unsigned();
			$table->foreign('docenteprovisorio_id')->references('id')->on('docentes');
			$table->integer('docentesuplente_id')->nullable()->unsigned();
			$table->foreign('docentesuplente_id')->references('id')->on('docentes');
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
		Schema::drop('asignardocente');
	}

}
