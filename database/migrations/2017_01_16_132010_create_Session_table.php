<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSessionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Session', function(Blueprint $table)
		{
			$table->increments('SessionID');
			$table->integer('UserID')->unsigned()->nullable();
			$table->string('IP', 50)->nullable();
			$table->string('Session', 50)->nullable();
			$table->dateTime('LoginDate')->nullable();
			$table->dateTime('LocalLoginDate');
			$table->dateTime('LogoutDate')->nullable();
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
		Schema::drop('Session');
	}

}
