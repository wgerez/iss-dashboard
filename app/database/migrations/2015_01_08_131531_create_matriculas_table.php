<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatriculasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('matriculas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('organizacion_id')->unsigned();
			$table->foreign('organizacion_id')->references('id')->on('organizaciones');
			$table->integer('carrera_id')->unsigned();
			$table->foreign('carrera_id')->references('id')->on('carreras');
			$table->integer('ciclolectivo_id')->unsigned();
			$table->foreign('ciclolectivo_id')->references('id')->on('cicloslectivos');
			$table->boolean('matriculaaplica')->default(0);
			$table->boolean('cuotaaplica')->default(0);
			$table->decimal('matriculaimporte',7,2)->nullable();
			$table->decimal('cuotaimporte',6,2)->nullable();
			$table->integer('matriculaperiodopagodesde')->nullable();
			$table->integer('matriculaperiodopagohasta')->nullable();
			$table->integer('cuotaperiodopagodesde')->nullable();
			$table->integer('cuotaperiodopagohasta')->nullable();
			$table->integer('cuotasporcarrera')->nullable();
			$table->integer('cuotasporciclo')->nullable();
			$table->integer('cuotasporperiodo')->nullable();
			$table->integer('mespagocuotainicio')->nullable();
			$table->timestamp('fechavencimientomatricula')->nullable();
			$table->boolean('activo')->default(1);
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
		Schema::drop('matriculas');
	}

}
