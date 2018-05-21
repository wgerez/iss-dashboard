<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlumnoslegajosdocumentosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('alumnoslegajosdocumentos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('alumnolegajo_id')->unsigned();
			$table->foreign('alumnolegajo_id')->references('id')->on('alumnoslegajos');
			$table->string('tipodocumento',200)->nullable();
			$table->string('documento',500)->nullable();
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
		Schema::drop('alumnoslegajosdocumentos');
	}

}
