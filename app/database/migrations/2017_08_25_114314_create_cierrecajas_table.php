<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCierrecajasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cierrecajas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');
			$table->timestamp('fechacierre')->nullable();
			$table->integer('cantidad500')->nullable();
			$table->decimal('total500',10,2)->default(0);
			$table->integer('cantidad200')->nullable();
			$table->decimal('total200',10,2)->default(0);
			$table->integer('cantidad100')->nullable();
			$table->decimal('total100',10,2)->default(0);
			$table->integer('cantidad50')->nullable();
			$table->decimal('total50',10,2)->default(0);
			$table->integer('cantidad20')->nullable();
			$table->decimal('total20',10,2)->default(0);
			$table->integer('cantidad10')->nullable();
			$table->decimal('total10',10,2)->default(0);
			$table->integer('cantidad5')->nullable();
			$table->decimal('total5',10,2)->default(0);
			$table->integer('cantidad2')->nullable();
			$table->decimal('total2',10,2)->default(0);
			$table->decimal('monedas',10,2)->default(0);
			$table->decimal('totalgeneral',12,2)->nullable();
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
		Schema::drop('cierrecajas');
	}

}
