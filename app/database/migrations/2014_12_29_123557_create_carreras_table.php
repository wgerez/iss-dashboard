<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarrerasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('carreras', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('organizacion_id')->unsigned();
			$table->foreign('organizacion_id')->references('id')->on('organizaciones');
			$table->string('carrera',500);
			$table->integer('carreranivel_id')->unsigned()->nullable();
			$table->foreign('carreranivel_id')->references('id')->on('carrerasniveles');
			$table->integer('tipocarrera_id')->unsigned()->nullable();
			$table->foreign('tipocarrera_id')->references('id')->on('tiposcarreras');
			$table->integer('regimen_id')->unsigned()->nullable();
			$table->foreign('regimen_id')->references('id')->on('regimenes');
			$table->integer('tipoduracion_id')->unsigned()->nullable();
			$table->foreign('tipoduracion_id')->references('id')->on('tiposduraciones');
			$table->integer('duracion')->nullable();
			$table->integer('modalidad_id')->unsigned()->nullable();
			$table->foreign('modalidad_id')->references('id')->on('modalidades');
			$table->integer('cargahorariacatedra')->nullable();
			$table->integer('cargahorariareloj')->nullable();
			$table->integer('areaocupacional_id')->unsigned()->nullable();
			$table->foreign('areaocupacional_id')->references('id')->on('areasocupacionales');
			$table->boolean('activa')->default(0);
			$table->boolean('exameningreso')->default(0);
			$table->string('observaciones',8000);
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
		Schema::drop('carreras');
	}

}
