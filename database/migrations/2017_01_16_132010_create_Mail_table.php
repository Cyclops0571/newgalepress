<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMailTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Mail', function(Blueprint $table)
		{
			$table->integer('MailID', true);
			$table->string('MailType', 50)->nullable();
			$table->timestamps();
			$table->integer('StatusID')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Mail');
	}

}
