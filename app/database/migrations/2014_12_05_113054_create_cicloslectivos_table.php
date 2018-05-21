<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCicloslectivosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cicloslectivos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('organizacion_id')->nullable()->unsigned();
			$table->foreign('organizacion_id')->references('id')->on('organizaciones');
			$table->string('descripcion',200);
			$table->timestamp('fechainicio')->nullable();
			$table->timestamp('fechafin')->nullable();
			$table->boolean('activo')->default(0);
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
		Schema::drop('cicloslectivos');
	}

}
