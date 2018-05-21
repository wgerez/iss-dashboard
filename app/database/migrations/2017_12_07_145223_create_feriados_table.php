<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeriadosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('feriados', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('organizacion_id')->unsigned();
			$table->foreign('organizacion_id')->references('id')->on('organizaciones');
			$table->integer('ciclolectivo_id')->unsigned();
			$table->foreign('ciclolectivo_id')->references('id')->on('cicloslectivos');
			$table->string('descripcion',300)->nullable();
			$table->timestamp('fecha_feriado')->nullable();
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
		Schema::drop('feriados');
	}

}
