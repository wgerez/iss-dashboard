<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCajachicaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cajachica', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('organizacion_id')->nullable()->unsigned();
			$table->foreign('organizacion_id')->references('id')->on('organizaciones');
			$table->integer('carrera_id')->nullable()->unsigned();
			$table->foreign('carrera_id')->references('id')->on('carreras');
			$table->integer('alumno_id')->nullable()->unsigned();
			$table->foreign('alumno_id')->references('id')->on('alumnos');
			$table->integer('concepto_id')->nullable()->unsigned();
			$table->foreign('concepto_id')->references('id')->on('concepto');
			$table->string('observacionconcepto',500)->nullable();
			$table->decimal('monto',6,2)->nullable();
			$table->integer('movimiento_id')->nullable()->unsigned();
			$table->foreign('movimiento_id')->references('id')->on('tipomovimiento');
			$table->string('numeromovimiento',500);
			$table->integer('formapago_id')->nullable()->unsigned();
			$table->foreign('formapago_id')->references('id')->on('formapago');
			$table->string('observacionpago',500)->nullable();
			$table->dateTime('fechatransaccion')->nullable();
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
		Schema::drop('cajachica');
	}

}
