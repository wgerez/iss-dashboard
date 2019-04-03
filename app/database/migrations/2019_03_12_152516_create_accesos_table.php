<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccesosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('accesos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('persona_id')->nullable()->unsigned();
			$table->foreign('persona_id')->references('id')->on('personas');
			$table->dateTime('entrada')->nullable();
			$table->dateTime('salida')->nullable();
			$table->integer('tipo')->nullable();
			$table->boolean('visto')->default(0);
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
		Schema::drop('accesos');
	}

}
