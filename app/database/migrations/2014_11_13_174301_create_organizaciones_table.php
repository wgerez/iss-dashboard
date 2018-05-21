<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrganizacionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('organizaciones', function(Blueprint $table) {
			$table->increments('id');
			$table->string('nombre',300)->nullable();
			$table->string('razon_social',300)->nullable();
			$table->string('cuit',20)->nullable();
			$table->integer('nivel_Educativo_id')->unsigned()->nullable();
			$table->foreign('nivel_Educativo_id')->references('id')->on('niveles_educativos');
			$table->boolean('habilitar_sedes')->default(0);
			$table->integer('pais_id')->unsigned();
			$table->foreign('pais_id')->references('id')->on('paises');
			$table->integer('provincia_id')->unsigned()->nullable();
			$table->foreign('provincia_id')->references('id')->on('provincias');
			$table->integer('departamento_id')->unsigned()->nullable();
			$table->foreign('departamento_id')->references('id')->on('departamentos');
			$table->integer('localidad_id')->unsigned()->nullable();
			$table->foreign('localidad_id')->references('id')->on('localidades');
			$table->integer('barrio_id')->unsigned()->nullable();
			$table->foreign('barrio_id')->references('id')->on('barrios');
			$table->string('barrio',500)->nullable();
			$table->string('calle',500)->nullable();
			$table->integer('numero')->nullable();
			$table->integer('manzana')->nullable();
			$table->string('piso',50)->nullable();
			$table->string('departamento',50)->nullable();
			$table->integer('codigo_postal')->nullable();
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
		Schema::drop('organizaciones');
	}

}
