<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePersonasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('personas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('apellido',100)->nullable();
			$table->string('nombre',100)->nullable();
			$table->integer('tipodocumento_id')->nullable()->unsigned();
			$table->foreign('tipodocumento_id')->references('id')->on('tipodocumentos');
			$table->string('nrodocumento',100)->nullable();
			$table->string('sexo',10)->nullable();
			$table->integer('estadocivil_id')->nullable()->unsigned();
			$table->foreign('estadocivil_id')->references('id')->on('estadosciviles');
			$table->dateTime('fechanacimiento')->nullable();
			$table->integer('lugarnacimiento_id')->unsigned()->nullable();
			$table->foreign('lugarnacimiento_id')->references('id')->on('paises');
			$table->integer('pais_id')->unsigned()->nullable();
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
			$table->string('manzana',50)->nullable();
			$table->string('piso',50)->nullable();
			$table->string('departamento',50)->nullable();
			$table->integer('codigo_postal')->nullable();
			$table->string('cuil',100)->nullable();
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
		Schema::drop('personas');
	}

}
