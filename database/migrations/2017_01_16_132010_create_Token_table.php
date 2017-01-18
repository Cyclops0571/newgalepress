<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTokenTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Token', function(Blueprint $table)
		{
			$table->increments('TokenID');
			$table->integer('CustomerID')->unsigned()->default(0);
			$table->integer('ApplicationID')->unsigned()->default(0);
			$table->string('UDID')->nullable();
			$table->string('ApplicationToken')->default('');
			$table->string('DeviceToken')->default('');
			$table->string('DeviceType', 20)->nullable();
			$table->integer('StatusID')->unsigned()->default(1);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Token');
	}

}
