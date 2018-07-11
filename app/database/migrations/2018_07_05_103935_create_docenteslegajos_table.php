<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocenteslegajosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('docenteslegajos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('docente_id')->unsigned();
			$table->foreign('docente_id')->references('id')->on('docentes');
			$table->boolean('dni')->default(0);
			$table->boolean('foto')->default(0);
			$table->boolean('cuil_cuit')->default(0);
			$table->boolean('partidanacimiento')->default(0);
			$table->boolean('cargos_actividades')->default(0);
			$table->boolean('declaracion_jurada')->default(0);
			$table->boolean('titulosecundario')->default(0);
			$table->boolean('tituloprofesional')->default(0);
			$table->boolean('ficha_medica')->default(0);
			$table->boolean('seguro')->default(0);
			$table->timestamp('fechavencimientoseguro')->nullable();
			$table->boolean('otros')->default(0);
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
		Schema::drop('docenteslegajos');
	}

}
