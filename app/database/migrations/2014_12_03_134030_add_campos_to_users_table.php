<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddCamposToUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->integer('tipodocumento_id')->nullable()->unsigned();
			$table->foreign('tipodocumento_id')->references('id')->on('tipodocumentos');
			$table->string('nrodocumento',100)->nullable();
			$table->string('email',200)->nullable();
			$table->boolean('activo',200)->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->dropColumn('tipodocumento_id');
			$table->dropColumn('nrodocumento');
			$table->dropColumn('email');
		});
	}

}
