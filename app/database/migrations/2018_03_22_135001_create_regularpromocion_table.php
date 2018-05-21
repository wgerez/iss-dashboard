<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegularpromocionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('regularpromocion', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('materia_id')->unsigned();
			$table->foreign('materia_id')->references('id')->on('materias');
			$table->integer('carrera_id')->nullable()->unsigned();
			$table->foreign('carrera_id')->references('id')->on('carreras');
			$table->integer('planestudio_id')->nullable()->unsigned();
			$table->foreign('planestudio_id')->references('id')->on('planesestudios');
			$table->integer('ciclolectivo_id')->unsigned();
			$table->foreign('ciclolectivo_id')->references('id')->on('cicloslectivos');
			$table->boolean('promocional')->default(0);
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
		Schema::drop('regularpromocion');
	}

}
