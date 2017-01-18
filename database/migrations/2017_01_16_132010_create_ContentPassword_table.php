<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContentPasswordTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ContentPassword', function(Blueprint $table)
		{
			$table->increments('ContentPasswordID');
			$table->integer('ContentID')->unsigned()->nullable();
			$table->string('Name', 50)->nullable();
			$table->string('Password')->nullable();
			$table->integer('Qty')->nullable();
			$table->integer('StatusID')->unsigned()->nullable();
			$table->integer('CreatorUserID')->unsigned()->nullable();
			$table->dateTime('DateCreated')->nullable();
			$table->integer('ProcessUserID')->unsigned()->nullable();
			$table->dateTime('ProcessDate')->nullable();
			$table->integer('ProcessTypeID')->unsigned()->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ContentPassword');
	}

}
