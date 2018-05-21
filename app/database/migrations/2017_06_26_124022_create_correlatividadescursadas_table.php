<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorrelatividadescursadasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('correlatividadescursadas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('correlatividad_id')->unsigned();
			$table->foreign('correlatividad_id')->references('id')->on('correlatividades');
			$table->integer('materia_id')->unsigned();
			$table->foreign('materia_id')->references('id')->on('materias');
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
		Schema::drop('correlatividadescursadas');
	}

}
