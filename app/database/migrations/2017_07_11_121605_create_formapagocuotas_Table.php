<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormapagocuotasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('formapagocuotas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('detallecuotaspago_id')->unsigned();
			$table->foreign('detallecuotaspago_id')->references('id')->on('detallescuotaspagos');
			$table->decimal('efectivo',12,2)->nullable();
			$table->decimal('tarjetacredito',12,2)->nullable();
			$table->decimal('tarjetadebito',12,2)->nullable();
			$table->decimal('cuentabancaria',6,2)->nullable();
			$table->decimal('cheque',12,2)->nullable();
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
		Schema::drop('formapagocuotas');
	}

}
