<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMailLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('MailLog', function(Blueprint $table)
		{
			$table->integer('MailLogID', true);
			$table->integer('MailID');
			$table->integer('UserID');
			$table->integer('Arrived')->default(0);
			$table->timestamps();
			$table->integer('StatusID');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('MailLog');
	}

}
