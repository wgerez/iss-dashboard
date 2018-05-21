<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDocentesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('docentes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('persona_id')->unsigned();
			$table->foreign('persona_id')->references('id')->on('personas');
			$table->integer('nrolegajo')->nullable();
			$table->string('foto')->nullable();
			$table->boolean('activo')->default(0);
			$table->boolean('empleado')->default(0);
			$table->boolean('disertante')->default(0);
			$table->timestamp('fechaingreso')->nullable();
			$table->timestamp('fechaegreso')->nullable();
			$table->integer('titulohabilitante_id')->unsigned();
			$table->foreign('titulohabilitante_id')->references('id')->on('tituloshabilitantes');
			$table->integer('organismohabilitante_id')->unsigned();
			$table->foreign('organismohabilitante_id')->references('id')->on('organismoshabilitantes');
			$table->string('nrolegajohabilitante',15)->nullable();
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
		Schema::drop('docentes');
	}

}
