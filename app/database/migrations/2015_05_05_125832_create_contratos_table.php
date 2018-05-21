<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContratosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contratos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('organizacion_id')->unsigned();
			$table->foreign('organizacion_id')->references('id')->on('organizaciones');
			$table->integer('tipocontrato_id')->unsigned();
			$table->foreign('tipocontrato_id')->references('id')->on('tiposcontratos');
			$table->integer('alumno_id')->unsigned();
			$table->foreign('alumno_id')->references('id')->on('alumnos');
			$table->integer('ciclolectivo_id')->nullable()->unsigned();
			$table->foreign('ciclolectivo_id')->references('id')->on('cicloslectivos');
			$table->dateTime('fechadesde')->nullable();
			$table->dateTime('fechahasta')->nullable();
			$table->integer('carrera_id')->nullable()->unsigned();
			$table->foreign('carrera_id')->references('id')->on('carreras');
			$table->integer('cantidadcuotas')->nullable();
			$table->decimal('cuotaimporte',6,2)->nullable();
			$table->decimal('matriculaimporte',6,2)->nullable();
			$table->decimal('totalimporte',6,2)->nullable();
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
		Schema::drop('contratos');
	}

}
