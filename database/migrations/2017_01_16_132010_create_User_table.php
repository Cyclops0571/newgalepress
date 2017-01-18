<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('User', function(Blueprint $table)
		{
			$table->increments('UserID');
			$table->integer('UserTypeID')->unsigned()->nullable();
			$table->integer('CustomerID')->unsigned()->nullable();
			$table->string('Username')->nullable();
			$table->string('FbUsername')->nullable();
			$table->binary('Password')->nullable();
			$table->string('FirstName', 50)->nullable();
			$table->string('LastName', 50)->nullable();
			$table->string('Email')->nullable();
			$table->string('FbEmail')->nullable();
			$table->string('FbAccessToken');
			$table->string('Timezone', 20)->nullable();
			$table->string('PWRecoveryCode', 20)->nullable();
			$table->dateTime('PWRecoveryDate')->nullable();
			$table->integer('StatusID')->unsigned()->nullable();
			$table->integer('CreatorUserID')->unsigned()->nullable();
			$table->dateTime('DateCreated')->nullable();
			$table->integer('ProcessUserID')->unsigned()->nullable();
			$table->dateTime('ProcessDate')->nullable();
			$table->integer('ProcessTypeID')->unsigned()->nullable();
			$table->string('ConfirmCode', 6)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('User');
	}

}
