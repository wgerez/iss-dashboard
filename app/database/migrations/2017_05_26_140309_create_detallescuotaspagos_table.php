<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetallescuotaspagosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('detallescuotaspagos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('inscripcion_id')->unsigned();
			$table->foreign('inscripcion_id')->references('id')->on('alumno_carrera');
			$table->integer('matricula_id')->unsigned();
			$table->foreign('matricula_id')->references('id')->on('matriculas');
			$table->integer('alumno_id')->unsigned();
			$table->foreign('alumno_id')->references('id')->on('alumnos');
			$table->integer('mescuota')->nullable();
			$table->decimal('importe',6,2)->nullable();
			$table->integer('porcentajerecargo')->nullable();
			$table->integer('porcentajedescuento')->nullable();
			$table->timestamp('fechavencimiento')->nullable();
			$table->timestamp('fechapago')->nullable();
			$table->boolean('estado')->default(0);
			$table->decimal('efectivo',6,2)->nullable();
			$table->decimal('tarjetacredito',6,2)->nullable();
			$table->decimal('tarjetadebito',6,2)->nullable();
			$table->decimal('cuentabancaria',6,2)->nullable();
			$table->decimal('cheque',6,2)->nullable();
			$table->string('observaciones',5000)->nullable();
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
		Schema::drop('detallescuotaspagos');
	}

}
