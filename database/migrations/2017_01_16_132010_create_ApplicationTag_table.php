<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateApplicationTagTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ApplicationTag', function(Blueprint $table)
		{
			$table->integer('ApplicationID')->unsigned();
			$table->integer('TagID')->unsigned();
			$table->primary(['ApplicationID','TagID']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ApplicationTag');
	}

}
