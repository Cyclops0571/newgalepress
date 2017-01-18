<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateServerErrorLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ServerErrorLog', function(Blueprint $table)
		{
			$table->integer('ServerErrorLogsID', true);
			$table->integer('Header');
			$table->text('Url', 65535);
			$table->text('Parameters', 65535);
			$table->text('ErrorMessage', 65535);
			$table->text('StackTrace', 65535);
			$table->dateTime('created_at');
			$table->date('updated_at');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ServerErrorLog');
	}

}
