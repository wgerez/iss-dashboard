<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocenteslegajosdocumentosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('docenteslegajosdocumentos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('docentelegajo_id')->unsigned();
			$table->foreign('docentelegajo_id')->references('id')->on('docenteslegajos');
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
		Schema::drop('docenteslegajosdocumentos');
	}

}
