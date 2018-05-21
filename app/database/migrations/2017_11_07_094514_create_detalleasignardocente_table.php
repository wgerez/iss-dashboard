<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleasignardocenteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('detalleasignardocente', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('asignardocente_id')->nullable()->unsigned();
			$table->foreign('asignardocente_id')->references('id')->on('asignardocente');
			$table->string('dia',100)->nullable();
			$table->string('horaentrada',50)->nullable();
			$table->string('horasalida',50)->nullable();
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
		Schema::drop('detalleasignardocente');
	}

}
