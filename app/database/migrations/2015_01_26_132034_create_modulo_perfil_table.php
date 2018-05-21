<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModuloPerfilTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('modulo_perfil', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('modulo_id')->unsigned();
			$table->foreign('modulo_id')->references('id')->on('modulos');
			$table->integer('perfil_id')->unsigned();
			$table->foreign('perfil_id')->references('id')->on('perfiles');
			$table->boolean('leer')->default(0);
			$table->boolean('editar')->default(0);
			$table->boolean('eliminar')->default(0);
			$table->boolean('imprimir')->default(0);
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
		Schema::drop('modulo_perfil');
	}

}
