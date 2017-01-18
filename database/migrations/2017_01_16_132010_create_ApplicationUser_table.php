<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateApplicationUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ApplicationUser', function(Blueprint $table)
		{
			$table->integer('ApplicationID')->unsigned()->default(0);
			$table->integer('UserID')->unsigned()->default(0);
			$table->primary(['ApplicationID','UserID']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ApplicationUser');
	}

}
