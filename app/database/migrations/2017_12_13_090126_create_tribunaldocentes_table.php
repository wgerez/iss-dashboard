<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTribunaldocentesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tribunaldocentes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('mesaexamen_id')->unsigned();
			$table->foreign('mesaexamen_id')->references('id')->on('mesaexamenes');
			$table->integer('docente_id')->unsigned();
			$table->foreign('docente_id')->references('id')->on('docentes');
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
		Schema::drop('tribunaldocentes');
	}

}
