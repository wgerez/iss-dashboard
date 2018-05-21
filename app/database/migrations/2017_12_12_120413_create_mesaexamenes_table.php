<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMesaexamenesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mesaexamenes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('organizacion_id')->unsigned();
			$table->foreign('organizacion_id')->references('id')->on('organizaciones');
			$table->integer('carrera_id')->unsigned();
			$table->foreign('carrera_id')->references('id')->on('carreras');
			$table->integer('materia_id')->unsigned();
			$table->foreign('materia_id')->references('id')->on('materias');
			$table->integer('ciclolectivo_id')->unsigned();
			$table->foreign('ciclolectivo_id')->references('id')->on('cicloslectivos');
			$table->integer('turnoexamen_id')->unsigned();
			$table->foreign('turnoexamen_id')->references('id')->on('turnoexamenes');
			$table->timestamp('fechaprimerllamado')->nullable();
			$table->string('horaprimerllamado',5)->default('00:00');
			$table->timestamp('fechasegundollamado')->nullable();
			$table->string('horasegundollamado',5)->default('00:00');
			$table->string('observaciones',1000)->nullable();
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
		Schema::drop('mesaexamenes');
	}

}
